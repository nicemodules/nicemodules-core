<script type="text/x-template" id='text-filter'>
    <div>
        {{ item[property] }}
    </div>
</script>
    
<script>
Vue.component('text-filter', {
        props: ['item', 'property'],
        template: '#text-filter',
    });
</script>