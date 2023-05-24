$("#make").on("change", function () {
    let makeFilterPath = productPath.replace('_make_id', $(this).val()).replace('_model_id', '');
    location.href = makeFilterPath;
  });
  $(function () {
    let modelTitle = "";
    modelTitle = $("#make").find('option:selected').text();
    $("#model-title").text(`${modelTitle} Models`);
    $(".model-checkbox").on("change", function () {
      var checkedBoxes = $('.model-checkbox:checked');
      // create an array to hold the values
      var checkedValues = [];
      // loop through the checked checkboxes and add their values to the array
      checkedBoxes.each(function () {
        checkedValues.push($(this).val());
      });
      let modelFilterPath = productPath.replace('_make_id', $("#make").val()).replace('_model_id', checkedValues.toString());
      location.href = modelFilterPath;
    });
  });