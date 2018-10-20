$(document).ready(function()
{
    var postId=0;
    var postBodyElement=null;

    $('.edit_post').on('click', function (event) {
   //    console.log('ok modal');
        event.preventDefault();

        postBodyElement = event.target.parentNode.parentNode.childNodes[1];
        var mypost= postBodyElement.textContent;
        postId= event.target.parentNode.parentNode.dataset['postid'];
        //console.log(mypost);
        $('#post-body').val(mypost);
        $('#edit-modal').modal();
    });

    $('#modal-save').on('click',function () {
        $.ajax({
            method: 'POST',
            url: url,
            data:{body: $('#post-body').val(), postId:postId, _token: token}
        })
            .done(function (msg) {
               // console.log(msg['message']);
                $(postBodyElement).text(msg['new-post']);
                  $('#edit-modal').modal('hide');
            })
    });

    $('.like').on('click',function(event)
    {
        //
        event.preventDefault();
        var action=event.target.previousElementSibling == null ? true : false;
        //console.log("url="+urlAction);
        postId= event.target.parentNode.parentNode.dataset['postid'];
        $.ajax({
            method: 'POST',
            url:urlAction,
            data:{action: action,postId:postId,_token:token}
        }).done(function(){
            //console.log("done "+urlAction);
            event.target.innerText = action ? event.target.innerText == 'Ti Piace' ? 'Ti piace questo post': 'Ti Piace' : event.target.innerText == 'Non Ti Piace' ? 'Non ti piace questo post' : 'Non Ti Piace';
            if(action)
            {
                event.target.nextElementSibling.innerText = 'Non Ti Piace';
            }
            else
            {
                event.target.previousElementSibling.innerText = 'Ti Piace';
            }
        });

    });

});

