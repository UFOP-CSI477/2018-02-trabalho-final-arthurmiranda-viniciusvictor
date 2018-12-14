@extends('layouts.app')

@section('content')
    @guest
        <div id="carouselControls" class="carousel slide m-auto w-75 pt-5" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselIndicators" data-slide-to="1"></li>
                <li data-target="#carouselIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{URL::asset('/img/people.jpg')}}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h1 class="font-koliko display-1">blankie</h1>
                        <h5>blankie é um sistema web que permite que os pais controlem facilmente as atividades diárias de seus recém-nascidos.</h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{URL::asset('/img/baby.jpg')}}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Acompanhe as atividades de seu recém-nascido.</h2>
                        <h5></h5>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{URL::asset('/img/bottle.jpg')}}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Crie sua conta e registre os dados de seu bebê para começar.</h2>
                        <p></p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    @else
    <div class="wrapper">
        <aside class="main_sidebar bg-white">
            <ul>
                <li <?php if($sidebar_selected == 0) : ?>class="active"<?php endif; ?>><a href="/">Atividades</a></li>
                <li <?php if($sidebar_selected == 1) : ?>class="active"<?php endif; ?>><a href="/babies">Meus bebês</a></li>
                <li <?php if($sidebar_selected == 2) : ?>class="active"<?php endif; ?>><a href="/babies/create">Cadastrar bebê</a></li>
                <li <?php if($sidebar_selected == 3) : ?>class="active"<?php endif; ?>><a href="/actions/create">Cadastrar atividade</a></li>
            </ul>
        </aside>
    </div>

    <div style="margin-left: 20vw; margin-top: 10vh; margin-right: 2vw; background: #FFFFFFC8; padding:2%">
        @if($sidebar_selected == 0)

                <form class="d-flex flex-row mb-3" method="POST" action="{{ route('actions.search') }}">
                    @csrf
                    <label for="baby_id" class="my-auto mr-4">Pesquisar por bebê:</label>
                    <select id="baby_id" name="baby_id" class="custom-select mr-4" style="min-width:12rem; max-width:12rem; ">
                        <option selected value="-1">Selecione...</option>
                        @foreach($babies as $baby)
                            <option <?php if(isset($info) && $info['baby_id'] == $baby->id):?>selected<?php endif; ?> value="<?=$baby->id?>"><?=$baby->name?></option>
                        @endforeach
                    </select>
                    <label for="date" class="my-auto mr-4">Data de início:</label>
                    <input type="date" id="date" name="date" class="form-control w-25 mr-2" <?php if(isset($info)):?>value="<?=$info['date']?>"<?php endif; ?>>
                    <button class="btn btn-success" type="submit">Pesquisar</button>
                </form>

            @if(count($actions) == 0)
                <h5>Nenhuma atividade encontrada.</h5>
            @endif

            @foreach($actions as $action)
            <div class="card border-info mb-3">
                <div class="card-body d-flex flex-row">

                    <div class="my-auto" style="width:8%">
                        @switch($action->type)
                            @case(0) <i class="fas fa-wine-bottle fa-3x ml-2 mr-4" style="color: #0062b3"></i> @break
                            @case(1) <i class="fas fa-child fa-3x ml-2 mr-4" style="color: #00b368"></i> @break
                            @case(2) <i class="fas fa-prescription-bottle-alt fa-3x ml-2 mr-4" style="color: #b30045"></i> @break
                            @case(3) <i class="fas fa-bed fa-3x ml-2 mr-4" style="color: #e9d30a"></i> @break
                        @endswitch
                    </div>

                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row">
                            <h3 class="align-self-end font-weight-bold"><?=$action->name?></h3>
                            <h4 class="align-self-end">, em {{ Carbon\Carbon::parse($action->date)->format('d/m/Y H:i') }}</h4>
                        </div>
                        <h5>
                            @switch($action->type)
                                @case(0) Mamadeira @break
                                @case(1) Troca de fralda @break
                                @case(2) Uso de Medicamento @break
                                @case(3) Tempo dormindo @break
                            @endswitch
                        </h5>
                        <h6><?=$action->description?></h6>
                    </div>

                    <div class="d-flex flex-row align-self-end ml-auto">
                        <form id="form-edit-action<?=$action->id?>" action="{{ route('actions.edit', $action->id) }}" method="GET" class="mr-3">
                            <a class="btn btn-info" href="#" onclick="document.getElementById('form-edit-action<?=$action->id?>').submit()"><i class="far fa-edit" style="color: white"></i></a>
                        </form>

                        <form id="form-delete-action<?=$action->id?>" action="{{ route('actions.destroy', $action->id) }}" method="POST" class="mr-3">
                            @csrf
                            <a class="btn btn-danger" href="#" onclick="document.getElementById('form-delete-action<?=$action->id?>').submit()"><i class="far fa-trash-alt"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
        
        @if($sidebar_selected == 1)

            @if(count($babies) == 0)
                <h5>Você ainda não cadastrou nenhum bebê.</h5>
            @endif

            @foreach($babies as $baby)
                <div class="card w-50 mx-auto mb-5">
                    <div class="card-body">

                        <div class="d-flex flex-row">
                            <h5 class="card-title font-weight-bold"><?=$baby->name?></h5>
                            <h5>, <?=$baby->getBabySex()?></h5>
                        </div>
                        
                        <p class="card-text"><?=$baby->getBabyBirthday() . ' ' . $baby->birthday->format('d/m/Y')?>.</p>
                        
                        <div class="d-flex flex-row">

                            <form action="{{ route('actions.search') }}" method="POST" class="mr-3">
                                @csrf
                                <input id="baby_id" name="baby_id" value="<?=$baby->id?>" style="display: none"></input>
                                <button class="btn btn-success" type="submit">Atividades</button>
                            </form>

                            <form action="{{ route('babies.edit', $baby->id) }}" method="GET" class="mr-3">
                                <button class="btn btn-warning" type="submit">Editar</button>
                            </form>

                            <form action="{{ route('babies.destroy', $baby->id) }}" method="POST" class="mr-3">
                                @csrf
                                <button class="btn btn-danger" type="submit">Excluir</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            
        @endif

        @if($sidebar_selected == 2)
            <div>
                @if(isset($baby))
                <form name="form-babies" method="POST" action="{{ route('babies.update', $baby->id) }}">
                @else
                <form name="form-babies" method="POST" action="{{ route('babies.store') }}">
                @endif

                    @csrf
                    <p>Utilize os campos abaixo para cadastrar novos bebês.</p>

                    <div class="form-group">

                        <div class="d-flex flex-row mb-3 ">
                            <label for="name" class="my-auto mr-4" style="width: 15%">Nome</label>
                            <input type="text" id="name" name="name" <?php if(isset($baby)):?>value="<?=$baby->name?>"<?php endif; ?> class="form-control w-25 mr-5">
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <label for="birthday" class="my-auto mr-4" style="width: 15%">Data de nascimento</label>
                            <input type="date" id="birthday" name="birthday" <?php if(isset($baby)):?>value="<?=$baby->birthday->format('Y-m-d')?>"<?php endif; ?> class="form-control w-25 mr-2">
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <label for="sex" class="my-auto mr-4" style="width: 15%">Sexo</label>
                            <select id="sex" name="sex" class="custom-select" style="min-width:12rem; max-width:12rem; ">
                                <option <?php if(isset($baby) && $baby->sex == 'M'):?>selected<?php endif; ?> value="M">Masculino</option>
                                <option <?php if(isset($baby) && $baby->sex == 'F'):?>selected<?php endif; ?> value="F">Feminino</option>
                            </select>
                        </div>                                
                        <button class="btn btn-success" type="submit">Adicionar</button>
                    </div>
                </form>
            </div>
        @endif

        @if($sidebar_selected == 3)
            <div>
                @if(isset($action))
                <form name="form-actions" method="POST" action="{{ route('actions.update', $action->id) }}">
                @else
                <form name="form-actions" method="POST" action="{{ route('actions.store') }}">
                @endif

                    @csrf
                    <p>Utilize os campos abaixo para cadastrar novas atividades.</p>

                    <div class="form-group">

                        <div class="d-flex flex-row mb-3">
                            <label for="baby_id" class="my-auto mr-4" style="width: 15%">Bebê</label>
                            <select id="baby_id" name="baby_id" class="custom-select" style="min-width:12rem; max-width:12rem; ">
                                @foreach($babies as $baby)
                                    <option <?php if(isset($action) && $action->baby_id == $baby->id):?>selected<?php endif; ?> value="<?=$baby->id?>"><?=$baby->name?></option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <label for="type" class="my-auto mr-4" style="width: 15%">Tipo</label>
                            <select id="type" name="type" class="custom-select" style="min-width:12rem; max-width:12rem; ">
                                <option <?php if(isset($action) && $action->type == 0):?>selected<?php endif; ?> value="0">Mamadeira</option>
                                <option <?php if(isset($action) && $action->type == 1):?>selected<?php endif; ?> value="1">Troca de fralda</option>
                                <option <?php if(isset($action) && $action->type == 2):?>selected<?php endif; ?> value="2">Medicamento</option>
                                <option <?php if(isset($action) && $action->type == 3):?>selected<?php endif; ?> value="3">Tempo dormindo</option>
                            </select>
                        </div> 

                        <div class="d-flex flex-row mb-3 ">
                            <label for="description" class="my-auto mr-4" style="width: 15%">Descrição</label>
                            <input type="text" id="description" name="description" class="form-control w-25 mr-5" <?php if(isset($action)):?>value="<?=$action->description?>"<?php endif; ?>>
                        </div>

                        <div class="d-flex flex-row mb-3">
                            <label for="date" class="my-auto mr-4" style="width: 15%">Data de início</label>
                            <input type="datetime-local" id="date" name="date" class="form-control w-25 mr-2" <?php if(isset($action)):?>value={{ Carbon\Carbon::parse($action->date)->format('Y-m-d\TH:i') }}<?php endif; ?>>
                        </div>

                        <button class="btn btn-success" type="submit">Adicionar</button>
                    </div>
                </form>
            </div>
        @endif

    </div>

    @endguest
@endsection
