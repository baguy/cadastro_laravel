$(document).ready(function(){
    $('#estado').on('change',function(){
        var estadoID = $(this).val();
        if(estadoID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'estado_id='+estadoID,
                success:function(html){
                    $('#cidade').html(html);
                    $('#city').html('<option value="">Select cidade first</option>');
                }
            });
        }else{
            $('#cidade').html('<option value="">Selecione estado primeiro</option>');
            // $('#city').html('<option value="">Select cidade first</option>');
        }
    });

    // $('#cidade').on('change',function(){
    //     var cidadeID = $(this).val();
    //     if(cidadeID){
    //         $.ajax({
    //             type:'POST',
    //             url:'ajaxData.php',
    //             data:'cidade_id='+cidadeID,
    //             success:function(html){
    //                 $('#city').html(html);
    //             }
    //         });
    //     }else{
    //         // $('#bairro').html('<option value="">Selecione cidade primeiro</option>');
    //     }
    // });
});
