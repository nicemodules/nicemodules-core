<script type="text/x-template" id='crud-top-button-actions'>
    <v-row justify="end">
        <template v-for="action of actions">

            <v-col cols="auto">
                <v-btn :color="action.color"
                       @click="buttonAction(action)"
                >
                    <v-icon left small>{{ action.icon }}</v-icon>
                    {{ action.label }}
                </v-btn>
            </v-col>

        </template>
    </v-row>
</script>

<script>
    Vue.component('crud-top-button-actions', {
        props: ['item', 'actions'],
        template: '#crud-top-button-actions',
        data: function () {
            return {
            };
        },
        methods: {
            buttonAction(action) {
                this.$root.executeAction({}, action)
            },
        },
        mounted: function () {
        },
        watch: {},
    });
</script>