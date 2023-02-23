<!DOCTYPE html>
<html>
  <head>
    <title>Data Provide</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>


  <body>
    <div class="container">


    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="addModalGenerate">
            Add
    </button>

      <div class="row justify-content-center">
            <div class="table-scroll">
                <table class=" table  table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>URL</th>
                            <th>IMAGE</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="addRow">
                        
                    </tbody>
                </table>
            </div> 

        <div class="col-md-6 col-sm-8">



                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Add Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="addForm">
                            <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="name">URL</label>
                                <input type="text" class="form-control" id="url" name="url" required>
                            </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Edit Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="updateForm">
                            <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="nameEdit" name="nameEdit" required>
                            </div>
                            <div class="form-group">
                                <label for="name">URL</label>
                                <input type="text" class="form-control" id="urlEdit" name="urlEdit" required>
                            </div>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control" id="itemId" name="editId" required>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>


                

        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  </body>

  <script>


    $(document).ready(function() {
        
        loadData();

        function loadData(){
            document.getElementById("name").value = '';
            document.getElementById("url").value = '';
            getResultUrl('api/v1/list').then(function(result){
                var itemList = $('#addRow');
                var items = result.data;
                itemList.empty();
                
                if(items.length === 0) {
                    itemList.append('<tr><td colspan="4">No data available</td></tr>');
                } else {
                    items.forEach(function(item) {
                        var itemHtml = '<tr>';
                            itemHtml += '<td>' + item.name + '</td>';
                            itemHtml += '<td> <a href="'+item.url+'">'+item.url+'</a> </td>';
                            itemHtml += '<td> <img src="'+item.url+'" height="100px" width="100px"> </td>';
                            itemHtml += '<td> <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editModal" data-id="'+item.id+'">Edit</button> <button type="button" class="btn btn-danger delete-item" data-id="'+item.id+'">Delete</button> </td>';
                            itemHtml += '</tr>';
                        itemList.append(itemHtml);

                    });
                }
            })
        }

        $('table').on('click', 'button[data-target="#editModal"]', function() {
            var itemId = $(this).data('id');
            getResultUrl('api/v1/item/' + itemId).then(function(result) {
                $('#editModal #itemId').val(result.data.id);
                $('#editModal #nameEdit').val(result.data.name);
                $('#editModal #urlEdit').val(result.data.url);
            });
        });

        $('table').on('click', '.delete-item', function() {
            var itemId = $(this).data('id');
            if(confirm("Are you sure you want to delete this item?")) {
                $.ajax({
                    url: 'api/v1/item/' + itemId,
                    type: 'DELETE',
                    success: function(result) {
                        loadData();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }
        });

        $('#addForm').submit(function(event) {
            event.preventDefault();
            var name = document.getElementById("name").value;
            var url = document.getElementById("url").value;
            var randomImage = '';

            if (isValidUrl(url)) {
                getResultUrl(url).then(function(result) {
                        $.ajax({
                        method: 'POST',
                        url: 'api/v1/add',
                        data: {
                            name: name,
                            url: result.message,
                        },
                        success: function(data) {
                            alert('Successfully Added');
                            $('#addModal').modal('hide');
                            loadData();
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr);
                            console.log(textStatus);
                            alert('Error:' + (errorThrown != '' ? errorThrown : 'Please check the URL'));
                        }
                    });
                }); 
            }else{
                alert('Error: Invalid URL');
            }
        });

        $('#updateForm').submit(function(event) {
            event.preventDefault();
            var name = document.getElementById("nameEdit").value;
            var url = document.getElementById("urlEdit").value;
            var id = document.getElementById("itemId").value;

            if (isValidUrl(url)) {

                if (isImageUrl(url)) {
                    $.ajax({
                        method: 'PUT',
                        url: 'api/v1/item/'+ id,
                        data: {
                            name: name,
                            url: url,
                        },
                        success: function(data) {
                            alert('Successfully Updated');
                            $('#editModal').modal('hide');
                            loadData();
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr);
                            console.log(textStatus);
                            alert('Error:' + (errorThrown != '' ? errorThrown : 'Please check the URL'));
                        }
                    });
                }else{
                    getResultUrl(url).then(function(result) {
                        $.ajax({
                            method: 'PUT',
                            url: 'api/v1/item/'+ id,
                            data: {
                                name: name,
                                url: result.message,
                            },
                            success: function(data) {
                                alert('Successfully Updated');
                                $('#editModal').modal('hide');
                                loadData();
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                console.log(xhr);
                                console.log(textStatus);
                                alert('Error:' + (errorThrown != '' ? errorThrown : 'Please check the URL'));
                            }
                        });
                    }); 

                }
            }else{
                alert('Error: Invalid URL');
            }
        });
        


        function getResultUrl(url){
            return $.ajax({
                type: 'get',
                url: url,
                success: function(res) {
                    if (res.status == "success") {
                        return res;
                    }
                },
                error: function(xhr, status, error) {
                    alert("Reqest doesn't return json");
                }
            });
        }


        function isValidUrl(url) {
            var pattern = new RegExp('^(https?:\\/\\/)?'+ 
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+
            '((\\d{1,3}\\.){3}\\d{1,3}))'+
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+
            '(\\?[;&a-z\\d%_.~+=-]*)?'+
            '(\\#[-a-z\\d_]*)?$','i');
            return pattern.test(url);
        }

        function isImageUrl(url) {
            var imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            var extension = url.split('.').pop().toLowerCase();
            return imageExtensions.includes(extension);
        }

    });

  </script>

</html>
