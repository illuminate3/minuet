  $('#year').on('change', function() {
    var year = this.value;
    if(year != '')
    {
      $.ajax({
        method: 'POST',
        url: "/user/product/"+year,
        data: {year: year}
      })
      .done(function (result) {
        console.log(result);
        $("#make").html(result.data)
        $("#model").html('<option>Select Model</option>')
      })
      .fail(function () {
          bootbox.alert('An error has occurred');
      });
    }
  });

  $('#make').on('change', function() {
    var make = this.value;
    var year = $('select#year option:selected').val();
    if(make != '' && year != '')
    {
      $.ajax({
        method: 'POST',
        url: "/user/product/"+year+'/'+make,
        data: {year: year, make: make}
      })
      .done(function (result) {
        console.log(result);
        $("#model").html(result.data)
      })
      .fail(function () {
          bootbox.alert('An error has occurred');
      });
    }
  });