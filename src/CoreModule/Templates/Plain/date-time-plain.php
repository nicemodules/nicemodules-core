<script type="text/x-template" id='date-time-plain'>
    <div>
        {{ item[property] }}
    </div>
</script>

<script>
    Vue.component('date-time-plain', {
        props: ['item', 'property'],
        template: '#date-time-plain',
    });
</script>