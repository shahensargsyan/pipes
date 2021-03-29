<div class="visual-swatches-wrapper attribute-swatches-wrapper form-group product__attribute product__color" data-type="visual">
    <div class="attribute-values">
        <ul class="visual-swatch color-swatch attribute-swatch">
            @foreach($attributes->where('attribute_set_id', $set->id) as $attribute)
                <li data-slug="{{ $attribute->slug }}" class="attribute-swatch-item"
                    title="{{ $attribute->title }}">
                    <div class="custom-radio choose_color">
                        <label class=" purple_color {{ in_array($attribute->id, $selected) ? 'active' : '' }}">
                            <input class="form-control product-filter-item color-check" type="radio" name="attribute_{{ $set->slug }}" value="{{ $attribute->id }}" {{ in_array($attribute->id, $selected) ? 'checked' : '' }}>
                            <label for="purple"><p  style="{{ $attribute->image ? 'background-image: url(' . RvMedia::getImageUrl($attribute->image) . ');' : 'background-color: ' . $attribute->color . ';' }}" class="color"></p></label>
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
