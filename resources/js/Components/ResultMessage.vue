<template>
   
    <div v-if="$page.props.flash.message" class="row justify-content-center pt-3">
        <div class="col-md-11">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                        <li>{{ $page.props.flash.message }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div v-if="Object.keys( $page.props.errors).length" class="row justify-content-center pt-3">
        <div class="col-md-11">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul>
                    <li v-for="(error, index) in $page.props.errors" :key="'error '+ index">{{ error }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div v-if="$page.props.flash.success" class="row justify-content-center pt-3">
        <div class="col-md-11">
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4><i class="icon fa fa-check"></i>{{$page.props.flash.success}}</h4>
            </div>
        </div>
    </div>
</template>