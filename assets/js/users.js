jQuery(document).ready(function(){

});

function editEmployer(employer_id){
  var data = {
    'action': 'employer_ajax_request',
    'request': 'edit',
    'employer_id': employer_id
  }
  genericAjaxRequest(data, 'json', 'get', 'populateEditEmployer');
}

function genericAjaxRequest(data, type, method, callback){
  var call_back = (callback != "" || callback != null || callback != undefined) ? callback : '';
  $.ajax({
    method: method,
    url: myAjax.ajaxurl,
    dataType: type,
    data: data,
    beforeSend: function(){
      showLightBox();
      //$('.loading').addClass('show');
    },
    success:function(data) {
      eval(call_back+"(data)");
    },
    complete: function(data){
      /*setTimeout(function(){
        $('.loading').removeClass('show');
      }, 500);*/

    }
  });
}

function showLightBox(){
  hideLightBox();
  $('body').append(`
    <div class="lightbox position-fixed">
      <div class="lightbox-content">
      </div>
    </div>
  `);
}

function hideLightBox(){
  $('.lightbox').remove();
}

function populateEditEmployer(data){

  $('.lightbox-content').append(`
    <div class="employer-edit employer-${data.ID} p-4">
      <form action="${myAjax.adminpost}" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6 mb-2">
            <span> Display Name: </span>
            <input type="text" name="user_nicename" class="form-control" value="${data.display_name}" required>
          </div>
          <div class="col-md-6 mb-2">
            <span> Email Address: </span>
            <input type="email" name="user_email" class="form-control" value="${data.user_email}" required>
          </div>
          <div class="col-md-6 mb-2">
            <span> Phone Number: </span>
            <input type="text" name="user_nicename" class="form-control" value="" placeholder="Soon" disabled>
          </div>
          <div class="col-md-6 mb-2">
            <span> Tel Number: </span>
            <input type="email" name="user_email" class="form-control" value="" placeholder="Soon" disabled>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <span>Bio: </span>
            <textarea class="form-control" rows="10"></textarea>
          </div>
        </div>
        <input type="hidden" name="action" value="edit_employer">
        <input type="hidden" name="employer_id" value="${data.ID}">
        <input type="submit" value="Submit" />
        <button onclick="hideLightBox();">Close</button>
      </form>
    </div>
  `);

}
