<template>
    <div class="container">
        <b-alert v-model="showAlert" dismissible style="position:absolute; top:65px; right:50px;">{{ alertText }}</b-alert>
        <!-- this button is me trying to test the swapi api response, poorly -->
        <button id="test-button" @click="getSwapiPeople()"></button>

        <b-nav-form style="margin-top:15px;">
            <b-form-input v-model="searchTerm" size="sm" class="mr-sm-2" type="text" placeholder="Search" />
            <b-button size="sm" class="my-2 my-sm-0" @click="searchSwapiPeople()">Search</b-button>
        </b-nav-form>

        <div class="row" style="margin-top:20px;">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Dramatis Personae</div>

                    <div class="card-body">
                        <div v-if="loading" class="text-center">
                            <b-spinner style="margin-top:50px;" type="grow" label="Spinning" />
                        </div>
                        <div v-else-if="people.length === 0">
                            <em>No data available</em>
                        </div>
                        <b-list-group v-else class="testref">
                            <b-list-group-item 
                                href="#" 
                                v-for="(person) in people" 
                                :key="person.name">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <span style="width:85%" @click.prevent="showDetails(person)">
                                        {{ person.name }}
                                    </span>
                                    <i 
                                        v-b-tooltip.hover :title="`Add ${person.name} to Favorites`"
                                        @click="addToFavorites(person)" 
                                        class="fas fa-plus" 
                                        style="cursor:pointer;">
                                    </i>
                                </div>
                            </b-list-group-item> 
                        </b-list-group>
                    </div>
                    <b-row align-h="center" style="margin-bottom:20px;">
                        <b-col cols="4" style="z-index:5;">
                            <b-row align-h="center">
                                <b-button @click="getPrevSwapiPeople()" :disabled="pageCount == 1" variant="success">Prev</b-button>
                            </b-row>
                        </b-col>
                        <b-col cols="4" style="z-index:5;">
                            <b-row align-h="center">
                                <b-button @click="getNextSwapiPeople()" variant="success">Next</b-button>
                            </b-row>
                        </b-col>
                        <b-col style="position:absolute; right:0px; bottom: 30px;">
                            <b-row align-h="center" align-v="center">
                                <small>Page: {{ pageCount }}</small>
                            </b-row>
                        </b-col>
                    </b-row>
                </div>
            </div>

            <favorites 
                v-model="favorites" 
                :loading="loading" 
                v-on:save-success="saveSuccess"
                v-on:deletion-successful="getFavorites" />

        </div>

        <edit-modal ref="detailsmodal">
            <h1 slot="header">{{ selectedPerson.name }}</h1>

            <div slot="content">
                <div class="mt-2">Name: {{ selectedPerson.name }}</div>
                <div class="mt-2">Hair Color: {{ selectedPerson.hair_color }}</div>
                <div class="mt-2">Mass: {{ selectedPerson.mass }}</div>
                <div class="mt-2">Height: {{ selectedPerson.height }}</div>
            </div>

            <b-button 
                slot="buttonleft" 
                class="mt-3" 
                variant="outline-danger" 
                @click="$refs.detailsmodal.hideModal()">Close</b-button>
        </edit-modal>

    </div>
</template>

<script>
    import Favorites from '@/js/components/Favorites.vue';
    import EditModal from '@/js/components/EditModal.vue';

    import api from '@/js/api';

    export default {
        components: {
            'edit-modal' : EditModal,
            'favorites' : Favorites,
        },
        data() {
            return {
                loading: true,
                people: [],
                favorites: [],
                pageCount: 1,
                searchTerm: '',
                showAlert: false,
                alertText: 'Coming Soon',
                selectedPerson: {}
            }
        },
        mounted() {
            this.getSwapiPeople();
        },
        methods: {
            async saveSuccess() {
                this.alertText = 'Success';
                this.showAlert = true; 
                try {
                    const favorites = await api.getFavorites();
                    this.favorites = favorites.data
                } catch(err) {
                    throw new Error(err.message)
                }
            },
            showDetails(person) {
                this.selectedPerson = person;
                this.$refs.detailsmodal.showModal();
            },
            async getSwapiPeople() {
                try {
                    const people = await api.getSwapiPeople();
                    this.people = people.data.results;
                    const favorites = await api.getFavorites();
                    this.favorites = favorites.data;

                    this.loading = false;
                } catch(err) {
                    this.loading = false;
                    throw new Error(err.message);
                }
            },
            async getNextSwapiPeople(){
                this.loading = true;
                this.pageCount++
                try {
                    const people = await api.getNextSwapiPeople(this.pageCount);
                    this.people = people.data.results;
                    this.loading = false;
                } catch (err) {
                    this.loading = false;
                    throw new Error(err);
                }
            },
            async getPrevSwapiPeople(){
                this.loading = true;
                if(this.pageCount <=1 ) {
                    this.pageCount == 1;
                } else {
                    this.pageCount--;
                }
                try {
                    const people = await api.getNextSwapiPeople(this.pageCount);
                    this.people = people.data.results;
                    this.loading = false;
                } catch (err) {
                    this.loading = false;
                    throw new Error(err)
                }
            },
            async addToFavorites(person) {
                api.addToFavorites(person).then(resp => {
                    return this.getFavorites();
                }).catch(err => {
                    console.log(err)
                })
            },
            async getFavorites() {
                try {
                    const favorites = await api.getFavorites();
                    this.favorites = favorites.data;
                } catch(err) {
                    throw new Error(err.message);
                }
            },
            async searchSwapiPeople(term) {
                this.alertText = "Coming Soon!";
                this.showAlert = true;
            }
        }
    }
</script>
<style scoped>
#test-button {
    display:hidden !important;
}
</style>