<?php
	// No direct access to this file
	defined( '_JEXEC' ) or die( 'Restricted access' );

//	echo'<pre>';print_r( $this->short_name['short_category_name']  );echo'</pre>'.__FILE__.' '.__LINE__;

?>

<fieldset>
    <legend>Основная информация</legend>
    <table width="100%" border="0">

        <tbody>
        <tr>
            <td class="key">
               Короткое название категории
            </td>
            <td>
<!--                required-->
	            <input type="text" class=" inputbox" id="short_category_name" name="short_category_name" size="37"
                       maxlength="255" value="<?=$this->short_name ?>">
	            <span class="langfallback"></span>
            </td>
        </tr>
        </tbody>
    </table>
</fieldset>
<input type="hidden" name="namespace" value="vm_admin_tools">
<?php
	vmJsApi::removeJScript('submit');
?>



<script>


    Joomla.submitbutton=function(a){

        var $ = jQuery ;

        var options = { path: '/', expires: 2}
        if (a == 'apply') {
            var idx = $('#tabs li.current').index();
            $.cookie('vmapply', idx, options);
        } else {
            $.cookie('vmapply', '0', options);
        }
        $( '#media-dialog' ).remove();
        form = document.getElementById('adminForm');
        form.task.value = a;


        
        
        if( a=='apply' || a=='save'){
           
        //    form.controller.value = 'vm_admin_tools.category';
            form.view.value = 'vm_admin_tools';
        }

       

        if( (a=='apply' || a=='save') && myValidator(form,false)){
            form.submit();
        } else if(a!='apply' && a!='save'){
            form.submit();
        }
        return false;
    };
    
    




</script>
