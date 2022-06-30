
<?php
if( true )  { ?>
  <div class="modal-header">
        <h5 class="modal-title">Mockup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
  <p>Hacer los mockups para presentar al usuario.</p>
  <h5>Subtareas</h5>
  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="">
                                <div class="todo-list">
                                    <div class="tdl-holder">
                                        <div class="tdl-content2 tdl-content--no-label">
                                            <ul>
                                                <li>
                                                    <label><input type="checkbox"><i></i><span>get up</span><a href='#' class="ti-close"></a>
                                                    </label>
                                                    
                                                
                                                </li>
                                                <li>
                                                    <label><input type="checkbox" checked><i></i><span>stand up</span><a href='#' class="ti-close"></a>
                                                    </label>
                                                    
                                                </li>
                                                <li>
                                                    <label><input type="checkbox"><i></i><span>don't give up the fight.</span><a href='#' class="ti-close"></a>
                                                    </label>
                                                    
                                                </li>
                                                <li>
                                                    <label><input type="checkbox" checked><i></i><span>do something else</span><a href='#' class="ti-close"></a>
                                                    </label>
                                                    
                                                </li>
                                                <li>
                                                    <label><input type="checkbox"><i></i><span>have fun</span><a href='#' class="ti-close"></a>
                                                    </label>
                                                    
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        <input type="text" class="tdl-new2 form-control" placeholder="Write new item and hit 'Enter'..." required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary">Guardar</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>

<div class="modal fade" id="my-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<?php } ?>


<script>




            window.localStorage.clear();
        $(document).ready(function () {

$('#list-items').html(localStorage.getItem('listItems'));

$('.add-items').submit(function(event) 
{
event.preventDefault();

var item = $('#todo-list-item').val();
if(item) 
{
$('#list-items').append("<li><div class='round d-inline-block'><input type='checkbox' id='checkbox' /><label for='checkbox'></label></div><label for='checkbox'>" + item + "</label><a class='remove'><i class='fa fa-trash'></i></a></li>");




// <div class='round'><input type='checkbox' id='checkbox' /><label for='checkbox'></label></div><label for='checkbox'>

// dfdfdf</label>





localStorage.setItem('listItems', $('#list-items').html());

$('#todo-list-item').val("");
}

});

$(document).on('change', '.checkbox', function() 
{
if($(this).attr('checked')) 
{
$(this).removeAttr('checked');
} 
else 
{
$(this).attr('checked', 'checked');
}

$(this).parent().toggleClass('completed');

localStorage.setItem('listItems', $('#list-items').html());
});


$(document).on('click', '.remove', function() 
{
$(this).parent().remove();

localStorage.setItem('listItems', $('#list-items').html());
});

});


</script>