<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://kit.fontawesome.com/3b8f060d8f.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="50">
    <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top" style="height: 40px">
        <div class="container">
            <a href="#header" class="navbar-brand">Navs</a>
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#work" class="nav-link">work</a></li>
                <li class="nav-item"><a href="#about" class="nav-link">about me</a></li>
                @auth
                    <li class="nav-item"><a href="{{ url('logout') }}" class="nav-link text-danger">Logout</a></li>
                @endauth
            </ul>
        </div>
    </nav>
    
    <div class="bg-secondary">

        {{-- header --}}
        <div class="container-fluid" id="header">
            <div class="container d-flex flex column section">
                <div class="container my-auto text-white">
                    
                    <h1 style="font-size: 5rem;">Hi I'm Navs</h1>
                    <p style="font-size: 1.6rem;">A graduate of <b>Bachelor of science in information technology</b></p>
                </div>
            </div>
        </div>
        
        <hr>
    
    
        {{-- work --}}
        <div class="container" id="work">
            <h1 class="display-4">My Work</h1>
            <div class="row justify-content-center">
                @foreach ($works as $work)
                    <div class="card col-3 m-1 clickable" style="height: 15rem" onclick="openWork('{{ $work->id }}')">
                        <div class="card-header">
                            <h1 class="card-title text-center">
                                @foreach ($work->technologies as $tech)
                                    <i class="{{ $tech->logo }}"></i>
                                @endforeach
                            </h1>
                        </div>
                        <div class="card-body d-flex">
                            <p class="text-center mx-auto my-auto" style="font-size: 1.5rem;">{{ $work->title }}</p>
                        </div>
                        
                    </div>
                @endforeach

                @auth
                    <div class="card col-3 m-1 clickable" style="background-color: rgb(168, 168, 168); height: 15rem;" onclick="addWork()">
                        <div class="card-body d-flex">
                            <h1 class="mx-auto my-auto"><i class="fa-solid fa-plus"></i></h1>
                        </div>                
                    </div>
                @endauth
            </div>

            


        </div>
        
        <hr>
    
        
        {{-- about --}}
        <div class="container" id="about">
        
            <h1 class="display-4">About me</h1>
            <div class="card w-75 mx-auto">

                <form action="{{ url('editAbout') }}" method="post">
                    @csrf
                    <div class="card-body" id="AboutMeSection">
                        <div id="aboutme" class="collapse show" data-bs-parent="#AboutMeSection">
                            @auth
                                <a href="#aboutmeField" data-bs-toggle="collapse" style="float: right;">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endauth
                            <p class="my-2">
                                Hi my name is {{ $profile->name }}.
                                <br><br>
                                {{ $profile->description }}
                            </p>
                        </div>
                        <div class="collapse" id="aboutmeField" data-bs-parent="#AboutMeSection">
                            <input type="submit" value="Update" class="btn btn-primary m-1 py-0" style="float: right">
                            <a href="#aboutme" data-bs-toggle="collapse" class="btn btn-danger m-1 py-0" style="float: right;">
                                Cancel
                            </a>
                            
                            <textarea name="editAbout" id="editAbout" cols="30" rows="5" class="form-control">{{ $profile->description }}</textarea>
                            
                        </div>
                            
                    </div>
                </form>
            </div>
    
            <hr>
            
            <div class="w-75 mx-auto" id="accordion">
                <div class="d-flex w-50">
                    <div class="me-1 tabBtn"><a href="#skills" data-bs-toggle="collapse" class="btn">Skills</a></div>
                    <div class="mx-1 tabBtn"><a href="#education" data-bs-toggle="collapse" class="btn">Education</a></div>
                    <div class="mx-1 tabBtn"><a href="#experience" data-bs-toggle="collapse" class="btn">Experience</a></div>
                </div>
                {{-- Skills --}}
                <div class="bg-white p-3 collapse show accordion-container" data-bs-parent="#accordion" id="skills">
                    
                    <div class="row collapse show" id="skillsDisplay" data-bs-parent="#skills">
                        @auth
                            <a href="#skillsEdit" data-bs-toggle="collapse" class="text-end">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endauth
                        @foreach ($categories as $cat)
                            <div class="col">
                                <p>
                                    <b>{{ $cat->name }}</b><br>
                                    @foreach ($cat->skills as $skill)
                                        {{ $skill->name }} <br>
                                    @endforeach
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="collapse" id="skillsEdit" data-bs-parent="#skills">
                        <form action="{{ url('updateSkills') }}" method="post">
                            @csrf
                            <div class="row">
                                @foreach ($categories as $cat)
                                <div class="col border rounded m-1 p-1">
                                   
                                    <div class="d-flex p-1">
                                        <b class="">{{ $cat->name }}</b>
                                        <div onclick="addField('skills-{{ $cat->id }}')" class="mx-2 clickable"><i class="fa-solid fa-plus text-success"></i></div>
                                        <div onclick="removeField('skillsContainer-{{ $cat->id }}')" class="mx-2 clickable"><i class="fa-solid fa-minus text-danger"></i></div>
                                    </div>
                                    <hr class="my-1">
                                    <div id="skillsContainer-{{ $cat->id }}">
                                        <input type="text" name="skills-{{ $cat->id }}[]" id="skills-{{ $cat->id }}" class="form-control py-0 w-75 mx-auto mt-1" value="" hidden>
                                        @foreach ($cat->skills as $skill)
                                        <input type="text" name="skills-{{ $cat->id }}[]" id="skills-{{ $cat->id }}" class="form-control py-0 w-75 mx-auto mt-1" value="{{ $skill->name }}">
                                        @endforeach
                                    </div>
                                 
                                </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="#skillsDisplay" data-bs-toggle="collapse" class="btn btn-danger py-0 mx-1">Cancel</a>
                                <input type="submit" value="Update" class="btn btn-primary py-0 mx-1">
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Education --}}
                <div class="bg-white p-3 collapse accordion-container" data-bs-parent="#accordion" id="education">
                    <div class="collapse show" id="educationDisplay" data-bs-parent="#education">
                        @auth
                        <a href="#educationEdit" data-bs-toggle="collapse" style="float: right;">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @endauth
                        @foreach ($educations as $educ)
                            <div class="d-flex my-2">
                                <img loading="lazy" src="{{ asset('Images/'.$educ->logo) }}" width="50px" height="50px">
                                <p class="my-auto ms-3">
                                    <b>{{ $educ->date }}</b><br>
                                    {{ $educ->title }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="collapse" id="educationEdit" data-bs-parent="#education">
                        <form action="{{ url('updateEduc') }}" method="post">
                            @csrf
                            <div>
                                <div class="row form-field" id="educForm" hidden>
                                    <div class="col-2 d-flex flex-column">
                                        <input type="file" name="educLogo[]" id="educLogo" class="form-control my-1" accept="image/*">
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="educDate[]" id="educDate" class="form-control">
                                        <input type="text" name="educTitle[]" id="educTitle" class="form-control my-1">
                                    </div>
                                </div>
                                @foreach ($educations as $educ)
                                <div class="row form-field">
                                    <div class="col-2 d-flex flex-column">
                                        <img loading="lazy" class="mx-auto" src="{{ asset('Images/'.$educ->logo) }}" height="30px">
                                        <input type="file" name="educLogo[]" id="educLogo" class="form-control my-1" accept="image/*">
                                    </div>
                                    <div class="col-10">
                                        <input type="hidden" name="educId[]" value="{{ $educ->id }}">
                                        <input type="text" name="educDate[]" id="educDate" class="form-control" value="{{ $educ->date }}">
                                        <input type="text" name="educTitle[]" id="educTitle" class="form-control my-1" value="{{ $educ->title }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
    
                            <div class="form-field clickable" style="background-color: rgb(168, 168, 168);" onclick="addInput('educForm')">
                                <div class="card-body d-flex">
                                    <h1 class="mx-auto my-auto"><i class="fa-solid fa-plus"></i></h1>
                                </div>                
                            </div>
                            
                            <div class="mt-1 d-flex justify-content-end">
                                <a href="#educationDisplay" data-bs-toggle="collapse" class="btn btn-danger py-0 mx-1">Cancel</a>
                                <input type="submit" value="Update" class="btn btn-primary py-0 mx-1">
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Experience --}}
                <div class="bg-white p-3 collapse accordion-container" data-bs-parent="#accordion" id="experience">
                    <div class="collapse show" data-bs-parent="#experience" id="experienceDisplay">
                        @auth
                            <a href="#experienceEdit" data-bs-toggle="collapse" style="float: right;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endauth
                        @foreach ($experiences as $ex)
                            <div class="d-flex mb-3">
                                <img loading="lazy" src="{{ asset('Images/'.$ex->logo) }}" width="50px" height="50px">
                                <p class="my-auto ms-3">
                                    <b>{{ $ex->date }}</b><br>
                                    {{ $ex->description }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="collapse" data-bs-parent="#experience" id="experienceEdit">
                        <form action="{{ url('updateExperience') }}" method="post">
                            @csrf
                            <div>
                                <div class="row form-field" id="exForm" hidden>
                                    <div class="col-2 d-flex flex-column">
                                        <input type="file" name="exLogo[]" id="exLogo" class="form-control my-1" accept="image/*">
                                    </div>
                                    <div class="col-10">
                                        <input type="text" name="exDate[]" id="exDate" class="form-control">
                                        <input type="text" name="exDescription[]" id="exDescription" class="form-control my-1">
                                    </div>
                                </div>
                                @foreach ($experiences as $ex)
                                    <div class="row form-field">
                                        <div class="col-2 d-flex flex-column">
                                            <img loading="lazy" class="mx-auto" src="{{ asset('Images/'.$ex->logo) }}" height="30px">
                                            <input type="file" name="exLogo[]" id="exLogo" class="form-control my-1" accept="image/*">
                                        </div>
                                        <div class="col-10">
                                            <input type="hidden" name="exId[]" value="{{ $ex->id }}">
                                            <input type="text" name="exDate[]" id="exDate" class="form-control" value="{{ $ex->date }}">
                                            <input type="text" name="exDescription[]" id="exDescription" class="form-control my-1" value="{{ $ex->description }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-field clickable" style="background-color: rgb(168, 168, 168);" onclick="addInput('exForm')">
                                <div class="card-body d-flex">
                                    <h1 class="mx-auto my-auto"><i class="fa-solid fa-plus"></i></h1>
                                </div>                
                            </div>
                            
                            <div class="mt-1 d-flex justify-content-end">
                                <a href="#experienceDisplay" data-bs-toggle="collapse" class="btn btn-danger py-0 mx-1">Cancel</a>
                                <input type="submit" value="Update" class="btn btn-primary py-0 mx-1">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>

        <hr>


        {{-- Contacts --}}
        <div class="container d-flex pb-3 justify-content-center">
            <a href="https://www.facebook.com/janavera00/">
                <i class="fa-brands fa-facebook mx-2 text-black" style="font-size: 25px"></i>
            </a>
            <a href="https://www.linkedin.com/in/john-arnulfo-navera-3ab695182/">
                <i class="fa-brands fa-linkedin mx-2 text-black" style="font-size: 25px"></i>
            </a>
            <a href="https://github.com/janavera00">
                <i class="fa-brands fa-github mx-2 text-black" style="font-size: 25px"></i>
            </a>
        </div>
    </div>
    
    @include('modals.workModal')
    @include('modals.addWorkModal')

    <script>
        function addInput(id){
            const template = document.querySelector(`#${id}`);
            const clone = template.cloneNode(true);
  
            clone.removeAttribute('id');
            clone.removeAttribute('hidden');

            template.parentNode.appendChild(clone);
        }
    </script>
</body>
</html>