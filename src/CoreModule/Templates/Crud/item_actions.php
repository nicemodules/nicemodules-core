<script type="text/x-template" id='crud-item-actions'>
    <div class="text-right">
        <template v-for="action of actions">
            <v-icon
                    @click="itemAction(item, action)"
                    :color="action.color"
            >
                {{ action.icon }}
            </v-icon>
        </template>
    </div>
</script>

<script>
    Vue.component('crud-item-actions', {
        props: ['item', 'actions'],
        template: '#crud-item-actions',
        data: function () {
            return {
            };
        },
        methods: {
            itemAction(item, action) {
                this.$root.executeAction(item, action);
            },
        },
        mounted: function () {
        },
        watch: {},
    });
</script>