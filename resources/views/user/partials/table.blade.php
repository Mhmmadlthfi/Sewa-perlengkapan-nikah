 <table class="table table-hover">
    <thead>
       <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No Telp</th>
          <th>Role</th>
          <th>Status</th>
          <th>Actions</th>
       </tr>
    </thead>
    <tbody class="table-border-bottom-0">
       @forelse ($users as $user)
          <tr>
             <td>
                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
             </td>
             <td>
                <strong>{{ $user->name }}</strong>
             </td>
             <td>{{ $user->email }}</td>
             <td>{{ $user->phone }}</td>
             <td>{{ ucfirst($user->role) }}</td>
             <td>
                @if ($user->is_active)
                   <span class="badge bg-label-success">Aktif</span>
                @else
                   <span class="badge bg-label-secondary">Tidak Aktif</span>
                @endif
             </td>
             <td>
                <a href="{{ route('user.show', $user) }}"
                   class="btn btn-sm btn-icon btn-outline-info">
                   <i class='tf-icons bx bx-file-find'></i></a>
                <a href="{{ route('user.edit', $user) }}"
                   class="btn btn-sm btn-icon btn-outline-warning"><i
                      class='tf-icons bx bx-edit'></i></a>
                <form action="{{ route('user.destroy', $user) }}" method="post"
                   class="d-inline">
                   @csrf
                   @method('DELETE')
                   <button
                      class="btn btn-sm btn-icon btn-outline-danger @if (!$user->can_delete) disabled @endif"
                      onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                         class='tf-icons bx bx-trash'></i></button>
                </form>
             </td>
          </tr>
       @empty
          <tr>
             <td colspan="7" class="text-center">Tidak ada data</td>
          </tr>
       @endforelse
    </tbody>
 </table>
