@extends('layouts.app') 
@section('title', 'Mi bandeja') 
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        {!!Breadcrumbs::render('inbox')!!}
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <tabs-content :rol-id="{{Muserpol\Helpers\Util::getRol()}}" :user="{{Muserpol\Helpers\Util::getAuthUser()}}" :inbox-state="`edited`"
            inline-template>
            <div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content mailbox-content">
                            <div class="file-manager">
                                {{-- <a class="btn btn-block btn-primary compose-mail" ui-sref="email_compose">Compose Mail</a> --}}
                                <div class="space-25"></div>
                                <h5>Tramites</h5>
                                <ul class="folder-list m-b-md" style="padding: 0">
                                    <li>
                                        <a href="{{ url('inbox/received') }}" class="btn-outline"> <i class="fa fa-envelope-o "></i> Recibidos
                                        {{-- <span class="label label-warning pull-right">@{{totalDocs}}</span> --}}
                                    </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('inbox/edited') }}" class="btn-outline" style="border-left:5px solid #59B75C; padding-left:10px; color: #3c3c3c; background:#F8F8F9;font-weight: bold;"> <i class="fa fa-check"></i> Revisados
                                        {{-- <a href="{{ url('inbox/edited') }}" class="btn-outline" style="background: #59B75C; color: #fff; font-weight: bold;"> <i class="fa fa-check"></i> Revisados --}}
                                        <span class="label label-warning pull-right">@{{totalDocs}}</span>
                                    </a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 animated fadeInRight">
                    <div class="mail-box-header">
                        <h2>
                            <span>
                            Revisados (@{{totalDocs}})
                        </span>
                        </h2>
                        <div class="mail-tools tooltip-demo m-t-md" style="margin-bottom:45px;">
                            <div>
                                {{-- backward  --}}
                                <div class="col-md-5 text-center">
                                    <transition name="fade" enter-active-class="animated bounceInLeft" leave-active-class="animated bounceOutleft">
                                        <div class="input-group" v-if="docs > 0">
                                            <span class="input-group-btn">
                                                <button :disabled="! docs > 0 " class="btn " :class="{'btn-primary': docs > 0  }" @click="sendBackward()" data-toggle="tooltip"
                                                    data-placement="top" title="Enviar los tramites seleccionados"><i class="fa fa-arrow-left"></i> Enviar <i class="fa fa-send"></i> <strong>(@{{docs}})</strong></button>
                                            </span>
                                            <select name="" v-model="wfSequenceBack" id="" class="form-control">
                                                <option :value="null"> Seleccione a donde enviara los tramites </option>
                                                <option :value="wfs.wf_state_id" v-for="(wfs, index) in wfSequenceBackList">@{{wfs.wf_state_name}}</option>
                                            </select>
                                        </div>
                                    </transition>
                                </div>
                                <transition name="fade" enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
                                    <div class="col-md-2 text-center" v-if="! docs > 0 ">
                                        <button class="btn btn-default" @click="getData()" data-toggle="tooltip" data-placement="top" title="Actualizar">
                                            Actualizar <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>
                                </transition>
                                {{-- forward --}}
                                <div class="col-md-5 col-xs-offset-2 text-center">
                                    <transition name="fade" enter-active-class="animated bounceInRight" leave-active-class="animated bounceOutRight">
                                        <div class="input-group" v-if="docs > 0">
                                            <select name="" v-model="wfSequenceNext" id="" class="form-control">
                                                <option :value="null"> Seleccione a donde enviara los tramites </option>
                                                <option :value="wfs.wf_state_id"  v-for="(wfs, index) in wfSequenceNextList">@{{wfs.wf_state_name}}</option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button :disabled="! docs > 0 " class="btn" :class="{'btn-primary': docs > 0  }" @click="sendForward" data-toggle="tooltip"
                                                    data-placement="top" title="Enviar los tramites seleccionados">Enviar <i class="fa fa-send"></i> <strong>(@{{docs}})</strong>  <i class="fa fa-arrow-right">  </i></button>
                                            </span>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mail-box">
                        <vue-tabs @tab-change="handleTabChange">
                            <v-tab :title="`${itab.name} (${classification(itab.id).length})`" :dataId="itab.id" icon="fa fa-check" v-for="(itab, index) in workflows"
                                :key="`tab-edited-${index}`" :suffix="` <span class='badge'> ${classification(itab.id).length} </span>`">
                                <inbox-content :workflow-id="itab.id" :inbox-state="`edited`" :documents="classification(itab.id)"></inbox-content>
                                </tab>
                        </vue-tabs>
                    </div>
                </div>
            </div>
        </tabs-content>
    </div>
@endsection