@php
    Theme::layout('full-width');
@endphp

<div class="container">
    <div style="margin: 40px 0;">
        <h4 style="color: #f00">You need to setup your homepage first!</h4>

        <p><strong>1. Go to Admin → Plugins then activate all plugins.</strong></p>
        <p><strong>2. Go to Admin → Pages and create a page:</strong></p>

        <div style="margin: 20px 0;">
            <div>- Content:</div>
            <div style="border: 1px solid rgba(0,0,0,.1); padding: 10px; margin-top: 10px;direction: ltr;">
                <div>[simple-slider key="slider-home-1" style="boxes" ads_1="IYHICPADQD5X" ads_2="R4YAV9FECJUS"][/simple-slider]</div>
                <div>[product-categories style="wooden" title="Top Categories" limit="6"][/product-categories]</div>
                <div>[products style="wooden" title="Popular Products" limit="10"][/products]</div>
                <div>[deal-product flash_sale_id="1"][/deal-product]</div>
                <div>[gallery title="ninico-shop" limit="6" subtitle="Follow On" icon="fab fa-instagram"][/gallery]</div>
            </div>
            <br>
            <div>- Template: <strong>Full width</strong>.</div>
            <div>- Header style: <strong>Collapsed</strong>.</div>
        </div>

        <p><strong>3. Then go to Admin → Appearance → Theme options → Page to set your homepage.</strong></p>
    </div>

</div>
