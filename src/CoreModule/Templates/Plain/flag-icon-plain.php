<script type="text/x-template" id='flag-icon-plain'>
    <div>
        <template v-if="item[property]"> 
            <span :class="'fi fi-' + item[property] "></span>
        </template>
    </div>
</script>
    
<script>
    Vue.component('flag-icon-plain', {
        props: ['item', 'property'],
        template: '#flag-icon-plain',
        mounted: function () {
        },
    });
</script>