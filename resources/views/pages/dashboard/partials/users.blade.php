<div class="users-card">

    <div class="users-header">

        <div>

            <h3>

                Pengguna Terbaru

            </h3>

            <p>

                Daftar pengguna yang baru ditambahkan.

            </p>

        </div>

        <a href="{{ route('users.index') }}" class="users-link">

            Lihat Semua

        </a>

    </div>

    <div class="users-list">

        @forelse($recentUsers as $user)
            <div class="user-item">

                <div class="user-avatar">

                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif

                </div>

                <div class="user-content">

                    <div class="user-name">

                        {{ $user->name }}

                    </div>

                    <div class="user-email">

                        {{ $user->email }}

                    </div>

                </div>

                <div class="user-right">

                    <span class="user-role">

                        {{ ucfirst($user->role ?? 'User') }}

                    </span>

                    <small>

                        {{ $user->created_at->diffForHumans() }}

                    </small>

                </div>

            </div>

        @empty

            <div class="empty-state">

                Belum ada pengguna.

            </div>
        @endforelse

    </div>

</div>
