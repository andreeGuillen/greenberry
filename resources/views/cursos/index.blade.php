<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Laravel 8 ajax</title>
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
 
</head>
<body>
    <div style="padding: 30px;"></div>
    <div class="container">
        <h2 style="color: red;">
            <marquee behavior="" direction="">Laravel 8 Andree</marquee>
        </h2>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header"> Todos los cursos</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">categoria</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <span id="addT">Agregar nuevo curso</span>
                        <span  id="updateT">Actualizar curso</span>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nombre del curso</label>
                            <input type="text" class="form-control" id="name" placeholder="Ingresar nombre">
                        </div>
                        <div class="form-group">
                            <label for="des">Descripcion</label>
                            <textarea class="form-control" rows ="5" id = "descripcion" name="descripcion">{{old('descripcion')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cat">Categoria</label>
                            <input class="form-control" type = "text" id = "categoria" name="categoria" value="{{old('categoria')}}">
                        </div>
                        <button id="btnAgregar" type="submit" onclick = "addData()" class="btn btn-primary">Agregar</button>
                        <button id="btnActualizar" onclick="updateData()" type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>

    <script>
        $('#addT').show();
        $('#btnAgregar').show();
        $('#updateT').hide();
        $('#btnActualizar').hide();

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                
            }
        })

        function allData(){
            
           fetch('curso/allData', {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'GET'
            }).then(reponse =>{
                return reponse.json()
            }).then(dato => {
                var data="";
                for (let i in dato.datos){
                        data = data + "<tr>"
                        data = data +"<td>"+dato.datos[i].id+"</td>"
                        data = data +"<td>"+dato.datos[i].name+"</td>"
                        data = data +"<td>"+dato.datos[i].description+"</td>"
                        data = data +"<td>"+dato.datos[i].categoria+"</td>"
                        data = data +"<td>"
                        data = data + "<button class='btn btn-sm btn-primary mr-2'>Editar</button>"
                        data = data + "<button class='btn btn-sm btn-danger'>Eliminar</button>"
                        data = data +"</td>"
                        data = data + "</tr>"
                }
                $('tbody').html(data);
            });
        }
        allData();
        function clearData(){
            $('#name').val('');
            $('#descripcion').val('');
            $('#categoria').val('');
        }
        function addData(){
            var name = $('#name').val();
            var descripcion = $('#descripcion').val();
            var categoria = $('#categoria').val();
            const data = new FormData();
            data.append('name', name);
            data.append('descripcion', descripcion);
            data.append(' categoria', categoria);
            fetch('cursos/create', {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'POST',
                body: data
            }).then(function(response) {
                clearData();
                allData();
                console.log('agregado');
            }).catch(function(err) {
            console.log(err);
            });


            /*$.ajax({
                type: "POST",
                //url: '/curso/create/',
                dataType: 'json',
                data: {name:name, descripcion:descripcion, categoria:categoria},
                url: "{{ route('cursos.create') }}",
                success: function(response){
                    clearData();
                    allData();
                    console.log('agregado');
                }
            })*/
        }
    </script>

</body>
</html>