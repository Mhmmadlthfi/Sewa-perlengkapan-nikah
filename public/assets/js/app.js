document.addEventListener("alpine:init", () => {
    Alpine.store("order", {
        user: null,
        rental_start: "",
        rental_end: "",
        address: "",
        // delivery_fee: 0,
        notes: "",
        items: [],
        total: 0,
        quantity: 0,

        availability: "",
        flashError: "",
        loading: false,

        errors: {
            user: false,
            address: false,
            rental_start: false,
            rental_end: false,
            items: false,
        },

        get minRentalEnd() {
            const today = new Date().toISOString().split("T")[0];
            if (!this.rental_start) return today;
            // Return tanggal terbesar antara today dan rental_start
            return this.rental_start > today ? this.rental_start : today;
        },

        add(newItem) {
            const productItem = this.items.find(
                (item) => item.id === newItem.id
            );

            if (!productItem) {
                this.items.push({
                    ...newItem,
                    quantity: 1,
                    total: parseFloat(newItem.price),
                });
                this.quantity++;
                this.total += parseFloat(newItem.price);
            } else {
                // Jika barang sudah ada, cek apakah barang beda atau sama dengan yang ada di ringkasan order
                this.items = this.items.map((item) => {
                    // Jika barang berbeda
                    if (item.id !== newItem.id) {
                        return item;
                    } else {
                        // Jika barang sudah ada, tambah quantity dan totalnya
                        item.quantity++;
                        item.total = parseFloat(item.price) * item.quantity;
                        this.quantity++;
                        this.total += parseFloat(item.price);
                        return item;
                    }
                });
            }
        },

        remove(id) {
            // ambil item yang mau di remove berdasarkan id nya
            const productItem = this.items.find((item) => item.id === id);

            // jika item lebih dari satu
            if (productItem.quantity > 1) {
                // Telurusi satu satu
                this.items = this.items.map((item) => {
                    // jika bukan barang yang di klik
                    if (item.id !== id) {
                        return item;
                    } else {
                        item.quantity--;
                        item.total = parseFloat(item.price) * item.quantity;
                        this.quantity--;
                        this.total -= parseFloat(item.price);
                        return item;
                    }
                });
            } else if (productItem.quantity === 1) {
                // jika barangnya sisa 1
                this.items = this.items.filter((item) => item.id != id);
                this.quantity--;
                this.total -= parseFloat(productItem.price);
            }
        },

        // get finalTotal() {
        //     const deliveryFee = parseFloat(this.delivery_fee);
        //     return this.total + (isNaN(deliveryFee) ? 0 : deliveryFee);
        // },

        async checkAvailability() {
            this.errors.availability = ""; // Reset error
            this.loading = true;

            try {
                const response = await fetch("/check-availability", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector("meta[name=csrf-token]")
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        items: this.items.map((item) => ({
                            id: item.id,
                            quantity: item.quantity,
                        })),
                        rental_start: this.rental_start,
                        rental_end: this.rental_end,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || "Failed to check availability"
                    );
                }

                if (!data.success) {
                    this.errors.availability = data.message;
                    return false;
                }

                return true;
            } catch (e) {
                console.error("Error checking availability:", e);
                this.errors.availability =
                    e.message ||
                    "Terjadi kesalahan saat memeriksa ketersediaan.";
                return false;
            } finally {
                this.loading = false;
            }
        },

        async submitOrder() {
            const errors = {
                user: !this.user,
                address: this.address.trim() === "",
                rental_start: this.rental_start.trim() === "",
                rental_end: this.rental_end.trim() === "",
                items: this.items.length === 0,
            };
            this.errors = errors;
            if (Object.values(errors).some(Boolean)) {
                return;
            }

            this.loading = true;
            try {
                const available = await this.checkAvailability();
                if (!available) {
                    return;
                }
            } catch (e) {
                alert("Gagal memeriksa ketersediaan produk.");
                return;
            } finally {
                this.loading = false;
            }

            this.loading = true;
            const payload = {
                user: this.user,
                rental_start: this.rental_start,
                rental_end: this.rental_end,
                address: this.address,
                // delivery_fee: this.delivery_fee,
                notes: this.notes,
                items: this.items,
                total: this.total,
                // finalTotal: this.finalTotal,
            };

            try {
                const response = await fetch("/order", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector("meta[name=csrf-token]")
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        json_payload: JSON.stringify(payload),
                    }),
                });
                const data = await response.json();

                if (data.success && data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: function (result) {
                            window.location.href = `${data.redirect}?order_id=${result.order_id}&transaction_status=settlement`;
                        },
                        onPending: function (result) {
                            window.location.href = `${data.redirect}?order_id=${result.order_id}&transaction_status=pending`;
                        },
                        onError: function (result) {
                            window.location.href = `${data.redirect}?order_id=${result.order_id}&transaction_status=error`;
                        },
                        onClose: function () {
                            alert("Kamu belum menyelesaikan pembayaran.");
                        },
                    });
                } else {
                    alert(
                        "Gagal menyimpan order: " +
                            (data.message ?? "Terjadi kesalahan.")
                    );
                }
            } catch (error) {
                console.error("Gagal mengirim data:", error);
                alert("Terjadi kesalahan saat mengirim order.");
            } finally {
                this.loading = false;
            }
        },
    });
});

const rupiah = (number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(number);
};
