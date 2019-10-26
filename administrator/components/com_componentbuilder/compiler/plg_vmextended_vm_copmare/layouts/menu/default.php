<?php
	$doc = JFactory::getDocument();
	$doc->addStyleDeclaration('
	div#comparison{
	    padding:0;
	}
	div#comparison .hub-i-link-empty{
	    cursor: default;
    }
	a.hub-i-link.hub-i-link-empty.hub-i-comparison-link.sprite-side.whitelink {
        float: left;
        width: 100%;
        height: 100%;
        position: relative;
    }
	div#comparison i.total_products {
        border-color: #ff7f19;
        left: -12px;
        bottom: -7px;
        color: #fff;
        background: #ff7f19;
        width: 19px;
        height: 19px;
        padding: 4px;
    }
    div#comparison i.total_products+svg{
           /* margin-top: -4px;
            margin-left: 2px;*/
    }
    div#comparison.empty i.total_products {
        opacity: 0;
    }
	');
?>
<div name="splash-button" id="comparison" class="label empty" style="padding:0">
	<a href="#" class="hub-i-link hub-i-link-empty hub-i-comparison-link sprite-side whitelink">
        <i class="total_products"></i>
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none" viewBox="-1 -1 43 34" id="header-comparison" x="295" y="530">
			<path fill-rule="evenodd" clip-rule="evenodd"
			      d="M16.436 23.14c-.546 3.665-3.492 6.402-6.936 6.402s-6.39-2.737-6.936-6.403h13.872zM3.618 20.68L9.5 12.367l5.883 8.314H3.617zm15.31.86a2.61 2.61 0 0 0-.153-.338l-8.263-11.68A1.223 1.223 0 0 0 9.5 9c-.409 0-.777.19-1.012.522L.224 21.204a2.565 2.565 0 0 0-.153.339c-.025.079-.071.32-.071.368C0 27.474 4.262 32 9.5 32S19 27.474 19 21.91c0-.047-.047-.289-.071-.37zm19.508 1.6c-.545 3.665-3.492 6.402-6.936 6.402s-6.39-2.737-6.936-6.403h13.872zm-12.819-2.46l5.883-8.314 5.883 8.314H25.617zm15.312.86a2.475 2.475 0 0 0-.154-.338l-8.263-11.68A1.223 1.223 0 0 0 31.5 9c-.409 0-.777.19-1.011.522l-8.265 11.682a2.685 2.685 0 0 0-.153.339 2.48 2.48 0 0 0-.071.368C22 27.474 26.262 32 31.5 32S41 27.474 41 21.91c0-.047-.047-.289-.071-.37zM33.73 2.58h-9.592C23.527 1.03 22 0 20.293 0c-1.708 0-3.235 1.03-3.844 2.58h-9.18C6.568 2.58 6 3.126 6 3.801c0 .674.57 1.223 1.268 1.223h9.037C16.783 6.784 18.4 8 20.294 8c1.892 0 3.509-1.216 3.987-2.975h9.45c.699 0 1.269-.55 1.269-1.223 0-.675-.57-1.223-1.27-1.223z"
			      fill="#d2d2d2"/>
		</svg>
		
	</a>
</div>
