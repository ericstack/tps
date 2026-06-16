$(document).ready(function() {
//General Function
$('.modal').on('hidden.bs.modal', function () {
  window.location.reload();
});
$('input[type=text]').attr("autocomplete", "off");

//datatables
var inventoryTable = $('#inventory_data').DataTable({
  "processing":true,
  "serverSide":true,
  'paging'      : false,
  'lengthChange': false,
  'searching'   : true,
  'ordering'    : false,
  'info'        : true,
  'autoWidth'   : false,
  "ajax":{
   "url":"../../app/controller/inventorycontroller.php",
   "type":"POST",
   "data": {
      "action": 'load'
    }
  }
});


  // $("#f_date").css("display", "none");
  // $("#t_date").css("display", "none");


 //Modal function
  $('#addProd').on('click',function() {
    $('#productModal').modal('show');
    $('#product_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i> Add Product");
    $('#action').val('Add');
    $('#btn_action').val('Add');
    load_category()
  });

  $('#addPO').on('click',function() {
    $('#orderModal').modal('show');
    $('#order_form')[0].reset();
    $('.modal-title').html("<i class='fa fa-plus'></i>Create Purchase Order");
    $('#action').val('Add');
    $('#btn_action').val('Add');
    $('#span_product_details').html('');
    add_product_row();
    load_product_list();
    load_product();
  });
  
  //Load Function
  function load_category(){
    var action = 'category'
      $.ajax({
        url: "../../app/controller/categorycontroller.php",
        method: "POST",
        data: {
          action: 'category'
        },
        success: function(data) {
          $('#category').append(data);
        }
      });
  }
  
  

  function load_product_list(count = ''){    
    $.ajax({
      url: "../../app/controller/inventorycontroller.php",
      method: "POST",
      data: {
        action: 'loadlist'
      },
      success: function(data) {
        $('#product_id'+count).append(data);
      }
    });
  }

  function load_product(count = ''){    
    $('#product'+count).on('change',function() {
      alert($(this).val());
    });
    $.ajax({
      url: "../../app/controller/inventorycontroller.php",
      method: "POST",
      data: {
        action: 'singleprod'
      },
      success: function(data) {
        $('#product_id'+count).append(data);
      }
    });
  }


  function add_product_row(count = '')
  {
   var html = '';
   html += "<tr>"
   html += "<td>"
   html += "<select name='product_id[]' id='product_id" + count + "' class='form-control selectpicker' data-live-search='true' required>"
   html += "</select><input type='hidden' name='hidden_product_id[]' id='hidden_product_id'+count+'' />";
   html += "</td>"
   html += "<td>"
   html += "<input type='text' name='quantity[]' class='form-control' required />";
   html += "</td>"
   html += "<td>"
   html += "<input type='text' name='unitprice[]' class='form-control' required />";
   html += "</td>"
   html += "<td>"
   html += "<input type='text' name='total[]' class='form-control' required />";
   html += "</td>"
   html += "<td>"
   if(count == '')
   {
    html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
   }
   else
   {
    html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
   }
   html += "</td>"
  html += "</tr>"
   $('#purchaseTable tr:last').after(html);

  //  $('.selectpicker').selectpicker();
  }

  var count = 0;

  $(document).on('click', '#add_more', function(){
   count = count + 1;
   add_product_row(count);
   load_product_list(count);
  });
  $(document).on('click', '.remove', function(){
   $(this).closest('tr').remove();
  });

  ///Date picker
    // $('#daterange').daterangepicker();
  // //Date range picker with time picker
  //  $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
  //  //Date range as a button
  //  $('#daterange-btn').daterangepicker(
  //    {
  //      ranges   : {
  //        'Today'       : [moment(), moment()],
  //        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
  //        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
  //        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
  //        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
  //        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
  //      },
  //      startDate: moment().subtract(29, 'days'),
  //      endDate  : moment()
  //    },
  //    function (start, end) {
  //      $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
  //    }
  //  )

  $('#type').on('change', function() {
    var type = $(this).val();
    if (type == 'delivery') {
      $("#dateLabel1").html('From Date');
      $("#dateLabel2").html('To Date');
      $("#f_date").css("display", "");
      $("#t_date").css("display", "");

    } else if (type == 'task') {
      $("#dateLabel1").html('Assigned Date');
      $("#dateLabel2").html('Due Date');
      $("#f_date").css("display", "");
      $("#t_date").css("display", "");

    }
  });


  //Form Submission

  $('#product_form').on('submit', function(event) {
    event.preventDefault();

    $.ajax({
      url: "../../app/controller/inventorycontroller.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#alert-msg').removeAttr('style')
        $('#msg').html(data)
        $('#productModal').modal('toggle');
        $('#inventory_data').DataTable().ajax.reload();
      }
    });
  });



  $('#employeeform').on('submit', function(event) {
    event.preventDefault();
    // var action=$('#action').val();
    $.ajax({
      url:"core/action.php",
      method:"POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#myModal').modal('toggle');
        alert(data);
        $('#employeeform')[0].reset();
        window.location.reload();
        $('#msg').html(data) 
      }
    });
  });
  $('#customerform').on('submit', function(event) {
    event.preventDefault();
    //var action=$('#action').val();
    $.ajax({
      url: "core/action.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#myModal').modal('toggle');
        alert(data);
        $('#customerform')[0].reset();
        window.location.reload();
      }
    });
  });
  $('#orderform').on('submit', function(event) {
    event.preventDefault();
    // var action=$('#action').val();
    $.ajax({
      url: "core/action.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#myModal').modal('toggle');
        alert(data);
        $('#orderform')[0].reset();
        window.location.reload();
      }
    });
  });
  $('#taskform').on('submit', function(event) {
    event.preventDefault();
    // var action=$('#action').val();
    $.ajax({
      url: "core/action.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#myModal').modal('toggle');
        alert(data);
        $('#taskform')[0].reset();
        window.location.reload();
      }
    });
  });
  $('#deliveryform').on('submit', function(event) {
    event.preventDefault();
    // var action=$('#action').val();
    $.ajax({
      url: "core/action.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#myModal').modal('toggle');
        alert(data);
        $('#deliveryform')[0].reset();
        window.location.reload();
      }
    });
  });
  $('#userform').on('submit', function(event) {
    event.preventDefault();
    // var action=$('#action').val();
    $.ajax({
      url: "core/action.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function(data) {
        $('#myModal').modal('toggle');
        alert(data);
        $('#userform')[0].reset();
        window.location.reload();
      }
    });
  });


  //Update data
  $(document).on('click', '.updateProduct', function(){
    var prod_id = $(this).attr("id");
    var action = 'edit';

    $.ajax({
     url:"../../app/controller/inventorycontroller.php",
     method:"POST",
     
     data:{
       action:action,
       prod_id:prod_id
      },
     dataType:"json",
     success:function(data)
     {
      
      $('#productModal').modal('show');
      $('#product_name').val(data.name);
      $('#product_description').val(data.desc);
      $('#quantity').val(data.qty);
      $('#category').val(data.cat_id);
      $('.modal-title').text("Edit Product");
      $('#id').val(prod_id);
      $('#action').val("update");
      $('#productbtn').html("Update");
      $('#productbtn').removeClass("btn-primary");
      $('#productbtn').addClass("btn-success");
      load_category()
      inventoryTable.ajax.reload();
     }
    })
   });

});
