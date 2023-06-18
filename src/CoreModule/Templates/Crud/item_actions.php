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