<!-- <script>
  $(function ($) {
    var $delete_All = $('#$delete_All');
    $('#checkAll').click(function () {
      $('#tb').find('input').prop('checked', $(this).prop('checked'));
      $(this).prop('checked') ? $delete_All.show(200) : $delete_All.hide(200);
    })
    $('#tb').find('input').click(function () {
      var check = $('#tb').find('input').length;
      var checked = $('#tb :checked').length;
      checked == 0 ? $delete_All.fadeOut(200) : $delete_All.fadeIn(200);
      $('#checkAll').prop('checked', check == checked);
    })
  })
</script> -->
<script>
  $(function ($) {
    var $tb = $('#tb input');
    // console.log($tb);
    // console.log('id======' + $tb.data('id'));
    var $delete = $('#delete_All');
    var $checkAll = $('#checkAll');
    // 定义一个数组记录被选中的
    var allCheckeds = [];
    // $checkAll.on('change', function () {
    //   $tb.prop('checked', $checkAll.prop('checked'));
    //   if($checkAll.prop('checked')) {
    //     $('#tb :input').each(function (i, itme) {
    //       itme.data('id');
    //     });
    //   }
    // })
    console.log(allCheckeds);
    $tb.on('change', function () {
      var id = $(this).data('id');
      var action = $(this).data('action');
      var table = $(this).data('table');
      var check = $tb.length - 1;
      $checkAll.prop('checked', check == allCheckeds.length);
      if ($(this).prop('checked')) {
        allCheckeds.push(id);
      }else {
        allCheckeds.splice(allCheckeds.indexOf(id), 1);
      }

      // console.log(check + "=====" + allCheckeds.length);  
      // console.log(allCheckeds);
      allCheckeds.length && checkAll ? $delete.fadeIn(200) : $delete.fadeOut(200);
      $delete.prop('search', '?id=' + allCheckeds + '&' + 'action=' + action + '&' + 'table=' + table);
    })
  })
</script>