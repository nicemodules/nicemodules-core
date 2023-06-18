<script type="text/x-template" id='crud-bulk-actions'>

    <v-toolbar flat>
        <v-toolbar-title>
            {{ translation.labels.selected }}:
        </v-toolbar-title>

        <v-divider
                class="mx-4"
                inset
                vertical
        ></v-divider>
        
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
    </v-toolbar>
</script>