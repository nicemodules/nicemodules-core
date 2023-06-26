<script type="text/x-template" id='text-plain'>
    <div>
        {{ item[property] }}
    </div>
</script>
    
<script>
    Vue.component('text-plain', {
        props: ['item', 'property'],
        template: '#text-plain',
    });
</script>