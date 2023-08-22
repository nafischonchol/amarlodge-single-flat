<template>
    <div class="d-flex justify-content-between mt-2">
        <div class="search-div mt-1">
            <div class="dataTables_filter">
                <label>
                    <input type="search" class="form-control" :placeholder="translate('Search')" v-model="search"
                        aria-controls="DataTables_Table_0">
                </label>
            </div>
        </div>
        <div class=" mt-1">
            <label>
                <select v-model.number="dPerPage" class="form-control-overriding">
                    <option :value="item" v-for="(item, index) in items" :key="index">{{
                        item
                    }}
                    </option>
                </select>
            </label>
        </div>
    </div>
</template>

<script>
import debounce from 'lodash/debounce';
import "@/components/assets/dataTable.css";
export default {
    props: {
        perPage: {
            type: Number,
            required: true,
        },
        items: {
            type: Object,
            required: true,
        },
        fetchData: {
            type: Function,
            required: true,
        },
    },
    data() {
        return {
            search: '',
            dPerPage: 50,
        };
    },
    watch: {
        perPage: {
            immediate: true,
            handler(newVal) {
                this.dPerPage = newVal;
            }
        },
        dPerPage(perPage) {
            this.dPerPage = perPage;
            this.fetchData(1, this.dPerPage, this.search)
        },
        search: debounce(function (search) {
            this.search = search;
            this.fetchData(1, this.dPerPage, this.search)
        }, 500),
    },
}
</script>

