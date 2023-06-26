<script type="text/x-template" id='checkbox-plain'>
    <div>
        <template v-if="item[property]">
            <v-icon color="success">mdi-check-circle</v-icon>
        </template>
        <template v-else>
            <v-icon color="error">mdi-close-circle</v-icon>
        </template>
    </div>
</script>
    
<script>
    Vue.component('checkbox-plain', {
        props: ['item', 'property'],
        template: '#checkbox-plain',
    });
</script>