<template>
    <PageComponent title="Sincronización con la nube">
        <template v-slot:breadcrumbs>
            <v-breadcrumbs :items="breadcrumbs">
                <template v-slot:prepend>
                    <v-icon icon="$vuetify" size="small"></v-icon>
                </template>
            </v-breadcrumbs>
        </template>
        <template v-slot:header>
            <v-row align="center" no-gutters>
                    <v-col
                        cols="6"
                    >
                        <v-text-field
                            v-model="search"
                            prepend-inner-icon="mdi-magnify"
                            label="Buscar..."
                            single-line
                            hide-details
                            clear-icon="mdi-close-circle"
                            clearable
                            variant="outlined"
                            density="compact"
                            class="mb-3"
                        ></v-text-field>
                    </v-col>

                    <!-- <v-col cols="6" class="text-right">
                        <v-btn
                            size="small"
                            rounded="xl"
                            prepend-icon="mdi-plus"
                            @click="nuevo"
                            class="mr-1"
                            :disabled="user.is_admin"
                        >
                            Nuevo
                        </v-btn>
                    </v-col> -->
                </v-row>
        </template>
        <template v-slot:content>
            <v-row align="center" justify="left" dense>
                <v-col cols="12" md="4">
                    <v-card
                        append-icon="mdi-check"
                        class="mx-auto"
                        prepend-icon="mdi-domain"
                        subtitle="prepend-icon and append-icon"
                        title="Companies"
                    >
                        <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</v-card-text>
                        <v-card-actions>
                            <v-btn
                                color="deep-purple-accent-4"
                                text="Learn More"
                                variant="text"
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col cols="12" md="4">
                    <v-card
                        class="mx-auto"
                        subtitle="prepend and append"
                        title="Icons"
                    >
                        <template v-slot:prepend>
                            <v-icon color="primary" icon="mdi-account"></v-icon>
                            </template>
                            <template v-slot:append>
                            <v-icon color="success" icon="mdi-check"></v-icon>
                        </template>
                        <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</v-card-text>
                        <v-card-actions>
                            <v-btn color="orange" text="Share"></v-btn>

                            <v-btn color="orange" text="Explore"></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col cols="12" md="4">
                    <v-card
                        append-avatar="https://cdn.vuetifyjs.com/images/john.jpg"
                        class="mx-auto"
                        prepend-avatar="https://cdn.vuetifyjs.com/images/logos/v-alt.svg"
                        subtitle="prepend-avatar and append-avatar"
                        title="Avatars"
                    >
                        <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" md="4">
                    <v-card
                        class="mx-auto"
                        subtitle="prepend and append"
                        title="Avatars"
                    >
                        <template v-slot:prepend>
                        <v-avatar color="blue-darken-2">
                            <v-icon icon="mdi-alarm"></v-icon>
                        </v-avatar>
                        </template>
                        <template v-slot:append>
                        <v-avatar size="24">
                            <v-img
                            alt="John"
                            src="https://cdn.vuetifyjs.com/images/john.png"
                            ></v-img>
                        </v-avatar>
                        </template>
                        <v-card-text>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </template>

        <template v-slot:right_content>
        </template>

    </PageComponent>
    <!-- <v-row justify="center">
        <v-dialog
            v-model="dialog"
            persistent
            width="800"
        >
            <v-card>
                <v-card-title>
                    <span class="text-h5">Usuario</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                            >
                                <v-text-field v-show="false"
                                    v-model="usuario.id"
                                    type="hidden"
                                ></v-text-field>
                                <v-text-field
                                    v-model="usuario.name"
                                    label="Nombre"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="usuario.email"
                                    label="Email"
                                    hint="Escriba un Email válido"
                                    required
                                    type="email"
                                    :readonly="usuario.id ? true : false"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" v-show="!usuario.id || password_reset">
                                <v-text-field
                                    v-model="usuario.password"
                                    label="Password"
                                    persistent-hint
                                    required
                                    type="password"
                                    :readonly="usuario.id  && !password_reset ? true : false"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" v-show="!usuario.id || password_reset">
                                <v-text-field
                                    v-model="usuario.password_confirmation"
                                    label="Password confirmation"
                                    required
                                    type="password"
                                    :readonly="usuario.id  && !password_reset ? true : false"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="usuario.rol_id"
                                    label="Rol"
                                    density="compact"
                                    item-value="id"
                                    item-title="nombre"
                                    :items="system_roles"
                                    variant="outlined"
                                ></v-select>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn v-show="usuario.id"
                        color="blue-darken-1"
                        variant="text"
                        @click="setResetPassword"
                    >
                        Reset Password
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialog = false"
                    >
                        Close
                    </v-btn>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="guardar"
                        :disabled="!user.is_admin"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row> -->
    <Overlay v-if="loading" />
</template>
<script>

import store from '../../../../store';
import { computed } from 'vue';
import axiosClient from '../../../../axios';
import PageComponent from '../../../PageComponent.vue'
import Overlay from '../../../Overlay.vue';

export default {
    data() {
        return {
            loading: false,
            dialog: false,
            password_reset: false,
            user: computed(() => store.state.user.data),
            registro: {},
            breadcrumbs: [
                { title: 'Dashboard', disabled: false, href: '/' },
                { title: 'Módulos', disabled: true, href: '/modules' },
                { title: 'Nuevo', disabled: false, href: '/module/new' },
            ],
            search: '',
            itemsPerPage: 20,
            headers: [
                { title: 'Nombre', align: 'start', sortable: true, key: 'name' },
                { title: 'Key', align: 'start', sortable: true, key: 'key' },
                { title: 'Route', align: 'start', sortable: true, key: 'route' },
                { title: 'MDI Icon', align: 'start', sortable: true, key: 'mdi_icon' },
                { title: '', align: 'end',key: 'actions', sortable: false },
            ],
            status: [
                { id: 1, nombre: 'Activo' },
                { id: 2, nombre: 'Inctivo' },
            ],
            data: [],
            system_roles: [],
        }
    },
    created() {
        this.initReg();
        this.getData();
    },
    methods: {
        async getData() {

            let _this = this;
            this.loading = true;

            axiosClient.get(`/module`, this.requestHeaders())
                .then(response => {
                    _this.data = response.data;

                    _this.data.sort((a, b) => {
                        if (a.nombre < b.nombre) return -1;
                    });

                    _this.loading = false;
                })
                .catch(function (error) {
                    _this.loading = false;
                });
        },
        async getSystemRoles() {
            let _this = this;
            this.loading = true;

            axiosClient.get(`/system-roles`, this.requestHeaders())
                .then(response => {
                    _this.system_roles = response.data;

                    _this.system_roles.sort((a, b) => {
                        if (a.nombre < b.nombre) return -1;
                    });

                    _this.loading = false;
                })
                .catch(function (error) {
                    _this.loading = false;
                });
        },
        async guardar() {
            let _this = this;
            this.loading = true;

            let url = '';
            let payload = {
                ...this.usuario,
                cuenta_id: this.user.cuenta_id
            };

            if(this.usuario.id) url += `/user-update/${this.usuario.id}`;
            else url += `/register`;

            axiosClient.post(`${url}`, payload, this.requestHeaders())
                .then(response => {
                    _this.initReg();
                    _this.users();
                    _this.dialog = false;
                    _this.loading = false;
                })
                .catch(function (error) {
                    this.loading = false;
                });
        },
        nuevo() {
            this.initReg();
            this.dialog = true;
        },
        editItem (item) {
            this.usuario = {...item};
            this.dialog = true;
        },
        deleteItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        setResetPassword () {
            this.usuario.password = null;
            this.usuario.password_confirmation = null;
            this.password_reset = !this.password_reset;
        },
        initReg() {
            this.usuario = { id: null, name: null, email: null, password: null, rol_id: 1 };
        },
        requestHeaders() {
            return {headers: { Authorization: `Bearer ${this.token}` }};
        }
    },
    components: {
        PageComponent,
        Overlay,
    },
    watch: {
        usuario(val, oldval) {
            console.log(val)
        }
    }
}
</script>