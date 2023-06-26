<script type="text/x-template" id='select-plain'>
    <div>
        {{ item[property] }}
    </div>
</script>

<script>
    Vue.component('select-plain', {
        props: ['item', 'property'],
        template: '#select-plain',
    });
</script>