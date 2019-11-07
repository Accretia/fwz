<template>
    <div id="app">
        <fancy-grid-vue
                :title="title"
                :theme="'gray'"
                :width="width"
                :height="height"
                :data="this.data"
                :resizable="true"
                :defaults="defaults"
                :sel-model="'rows'"
                :trackOver="true"
                :columns="columns">
        </fancy-grid-vue>
    </div>
</template>

<script>
    import FancyGridVue from 'fancy-grid-vue';
    import axios from 'axios';
    export default {
        name: 'app',
        data: function(){
            return {
                title: "Vue with FancyGrid",
                theme: "gray",
                width: "auto",
                height: "auto",
                data: [],
                defaults: this.getDefaults(),
                columns: this.getColumns()
            };
        },
        created () {
            this.getData();
        },
        methods: {
            getColumns: function(){
                return [
                {
                    index: 'title',
                    title: 'title'

                },{
                    index: 'description',
                    title: 'Description',
                    width: 200
                },{
                    index: 'bathroom',
                    title: 'Bathroom'
                },{
                    index: 'bedroom',
                    title: 'Bedroom',
                    type: 'number',
                    width: 80
                },{
                    index: 'for_rent',
                    title: 'For rent',
                },{
                    index: 'for_sale',
                    title: 'For Sale',
                },{
                    index: 'region',
                    title: 'Region',
                }];
            },
            getDefaults: function(){
                return {
                    type: 'string',
                    width: 100,
                    sortable: true,
                    editable: true,
                    resizable: true,
                };
            },
            getData: function(){
                return axios.get(`/get_properties`)
                    .then(response => {
                        // JSON responses are automatically parsed.
                        console.log(response.data.data.data.data);
                        this.data = response.data.data.data.data;
                    })
                    .catch(e => {
                        this.errors.push(e)
                    });
            }
        },
        components: {
            FancyGridVue
        }
    }
</script>
