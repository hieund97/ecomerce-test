<div class="col-lg-9">
    <div class="shop__product__option">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                @include('client/partials/numberResult')
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="shop__product__option__right">
                    <p>Sort by Price:</p>
                    <select id="sort-by-select">
                        <option value="0">Low To High</option>
                        <option value="1">High To Low</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="spinner-border" style="width: 5rem; height: 5rem; margin-left: 50%" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <div class="row" id="product-item">
    </div>

    <input type="hidden" name="data-load-more" id="data-load-more">

    <div class="text-center">
        <button id="load-more-button" type="button" class="btn btn-primary">Load more</button>
    </div>
</div>

@push('js')
    <script>
        var imagePath = `{{ config('handle.show_image_path') }}`;

        $(document).ready(function() {
            getProduct(imagePath);

            if ($(".product__item").length > {{ config('handle.show_product') }}) {
                $('#load-more-button').show();
            }

            $('#load-more-button').on('click', function() {
                var dataLoadMore = $('#data-load-more').val();

                if (dataLoadMore.length > 0) {
                    dataLoadMore = JSON.parse($('#data-load-more').val());
                }

                $(this).prop('disabled', true);
                var ENDPOINT = "{{ url('/') }}";
                setTimeout(() => {
                    getProduct(imagePath, true, dataLoadMore);
                }, 200);
            });

            $('#sort-by-select').change(function() {
                var optionSelected = $("#sort-by-select:selected", this);
                var valueSelected = this.value;
            });
        });
    </script>
@endpush
