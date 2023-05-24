<script type="text/x-template" id='crud-filters'>
    <v-text-field
            v-model="idFilter"
            label="Id"
            append-icon="mdi-magnify"
    ></v-text-field>

    <v-text-field
            v-model="nameFilter"
            label="Name"
            append-icon="mdi-magnify"
    ></v-text-field>

    <v-text-field
            v-model="calories"
            type="number"
            label="Less than"
    ></v-text-field>

    <v-btn color="primary" class="ml-auto ma-3" v-on="on">
        Filtruj
        <v-icon small>mdi-magnify</v-icon>
    </v-btn>
</script>