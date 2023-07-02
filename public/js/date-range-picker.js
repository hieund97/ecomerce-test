$(function() {
    $('input[name="daterange"]').daterangepicker({
      opens: 'left'
    }, function(start, end, label) {
      console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
      // var value = start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY')
      // console.log(value);
      // $('input[name="daterange"]').val("hello");
    });
  });