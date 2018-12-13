<script>
  $(function ($) {
    $('#checkAll').click(function () {
      $('#tb').find('input').prop('checked', $(this).prop('checked'));
      $(this).prop('checked') ? $('#delete_All').show(200) : $('#delete_All').hide(200);
    })
    $('#tb').find('input').click(function () {
      var check = $('#tb').find('input').length;
      var checked = $('#tb :checked').length;
      checked == 0 ? $('#delete_All').hide(200) : $('#delete_All').show(200);
      $('#checkAll').prop('checked', check == checked);
    })
  })
</script>