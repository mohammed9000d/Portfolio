@extends('admin.parent')
@section('style')
<style>
    .avatar {
        position: relative;
        display: inline-block;
        width: 5rem;
        height: 3rem;
    }
    .avatar .rounded {
        border-radius: 6px !important;
    }
    .avatar > img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>

@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-5">
                    <h4 class="page-title">Projects</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">projects</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-7">
                    <div class="text-end upgrade-btn">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary text-white">Add</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- column -->
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table v-middle">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="border-top-0">ID</th>
                                        <th class="border-top-0">Image</th>
                                        <th class="border-top-0">Title</th>
                                        <th class="border-top-0">Description</th>
                                        <th class="border-top-0">Link</th>
                                        <th class="border-top-0">Created At</th>
                                        <th class="border-top-0">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>
                                                <div class="avatar">
                                                    <img class="avatar-img rounded" alt="User Image" src="{{ url('images/project/'.$project->image) }}">
                                                </div>
                                            </td>
                                            <td>{{ $project-> title}}</td>
                                            <td>{{ $project-> description}}</td>
                                            <td>{{ $project-> link}}</td>
                                            <td>{{ $project-> created_at}}</td>
                                            <td>
                                                <a href = "{{ route('projects.edit', [$project->id]) }}" class="btn btn-primary text-white">Edit</a>
                                                <a href = "#" onclick = "confirmDelete(this,'{{ $project->id }}')" type="button" class="btn btn-danger text-white">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-center">
            All Rights Reserved by Xtreme Admin. Designed and Developed by <a href="https://www.wrappixel.com">WrapPixel</a>.
        </footer>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('portfolio/js/axios.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function confirmDelete(app,id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                deleteSpecialty(app,id)
                }
            })
        }
        function deleteSpecialty(app,id){
            axios.delete('/cms/admin/projects/'+id)
            .then(function (response) {
            // handle success
            console.log(response);
            app.closest('tr').remove();
            showDeleted(response.data);
            })
            .catch(function (error) {
            // handle error
            console.log(error);
            })
            .then(function () {
            // always executed
            });
    }
        function showDeleted(data){
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showConfirmButton:false,
                timer: 2000,
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer')
                }
            })
        }
</script>



@endsection



