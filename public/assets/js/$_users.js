$(document).ready(function () {

	var rolesCheckbox = $('#roles input:checkbox');

  $.each(rolesCheckbox, function (index) {

    var count = index + 1;

    $(`#role_${count}`).on('ifClicked', function() {

      $(this).on('ifChecked', function() {

        for (var i = count; i < (rolesCheckbox.length + 2); i++) {

          $(`#role_${i}`).iCheck('check');
        }
      });

      $(this).on('ifUnchecked', function() {

        for (var i = count; i < (rolesCheckbox.length + 2); i++) {

          $(`#role_${i}`).iCheck('uncheck');
        }
      });
    });
  });
});
