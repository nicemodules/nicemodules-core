<script type="text/x-template" id='actions-plain'>

    <crud-item-actions :item="item" :actions="$root.options.itemActions"></crud-item-actions>

</script>

<script>
    Vue.component('actions-plain', {
        props: ['item', 'property'],
        template: '#actions-plain',
    });
</script>