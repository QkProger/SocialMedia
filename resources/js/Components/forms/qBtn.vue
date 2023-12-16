<template>
    <button class="btn cst_btn aj-c" :class="{
           success: mode == 1,
           danger: mode == 2,
           focus: mode == 3
       }">
        {{num}}
    </button>
</template>


<script>
export default {
    props: ['mode', 'num'],
}
</script>


<style scoped lang="scss">
    .cst_btn{
        width: 30px;
        height: 30px;
        background: #F9F9F9;
        border: 1px solid #D6D6D6;
        color: #888888;
        font-family: Gilroy;
        font-size: 18px;
        font-weight: 700;
        line-height: 22px;
        padding: 0;
        transition: 0.3s;
        &:hover{
            border: 1px solid #000000;
        }
        &.success, &.danger, &.focus{
            color: #FFFFFF;
        }
        &.success{
            background: #03B113;
        }
        &.danger{
            background: #FF0000;
        }
        &.focus{
            background: #0045CB;
        }
    }
</style>
