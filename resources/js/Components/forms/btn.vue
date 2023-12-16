<template>
    <button class="btn cst_btn" :class="{square:square, disabled:disabled}">
        <img v-if='img' :src='getImgUrl(img)' alt="">
        <div v-if='loading' class="spinner-border" role="status"></div>
        <span v-else>{{text}}</span>
        <img v-if='imgToRight' :src='getImgUrl(imgToRight)' class="right" alt="">
    </button>
</template>


<script>
export default {
    props: ['text','img', 'square', 'imgToRight', 'disabled', 'loading'],
    methods: {
        getImgUrl(pet) {
            var images = require.context('@/assets/images/', false)
            return images('./' + pet)
        },
    }
}
</script>


<style scoped lang="scss">
    .spinner-border{
        width: 1rem;
        height: 1rem;
    }
    .cst_btn{
        width: 100%;
        height: 100%;
        background: #1E63E9;
        border-radius: 9999px;
        color: #FFFFFF !important;
        &:hover{background: #0045CB;}
        &:focus{background: #0045CB;}
        &:active{background: #0037A1;}
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;
        font-weight: 500;
        line-height: 16px;

        &.square{
            border-radius: 6px;
        }
        &.disabled{
            background: #A0A0A0;
            &:hover{background: #A0A0A0;}
            &:focus{background: #A0A0A0;}
            &:active{background: #A0A0A0;}
        }
        img{
            margin: 0 10px 0 0;
            &.right{
                margin: 0 0 0 10px;
            }
        }
    }
</style>
<style>
    .cst_btn{
        font-size: inherit;
    }
</style>
