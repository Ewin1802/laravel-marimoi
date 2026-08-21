<div class="product-panel">

    {{-- ==========================
        TOP PRODUK
    =========================== --}}

    <div class="panel-card">

        <div class="panel-header">

            <h3>

                Produk Terlaris

            </h3>

            <span>

                Top 10

            </span>

        </div>

        @forelse($topProducts as $index => $product)
            <div class="product-item">

                <div class="product-left">

                    <div class="product-rank">

                        {{ $index + 1 }}

                    </div>

                    <div>

                        <div class="product-name">

                            {{ $product->name }}

                        </div>

                        <small>

                            {{ number_format($product->total_qty) }} terjual

                        </small>

                    </div>

                </div>

                <div class="product-right">

                    Rp {{ number_format($product->omzet, 0, ',', '.') }}

                </div>

            </div>

        @empty

            <div class="empty-state">

                Belum ada transaksi.

            </div>
        @endforelse

    </div>

    {{-- ==========================
        STOK MENIPIS
    =========================== --}}

    <div class="panel-card">

        <div class="panel-header">

            <h3>

                Stok Menipis

            </h3>

            <span>

                ≤ 5

            </span>

        </div>

        @forelse($lowStockProducts as $product)
            <div class="stock-item">

                <div>

                    <div class="product-name">

                        {{ $product->name }}

                    </div>

                    <small>

                        {{ $product->category->name ?? '-' }}

                    </small>

                </div>

                <span class="stock-badge">

                    {{ $product->stock }}

                </span>

            </div>

        @empty

            <div class="empty-state">

                Semua stok masih aman.

            </div>
        @endforelse

    </div>

</div>
