<template>
    <PageComponent title="Usuarios">
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
            <v-data-table
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items="usuarios"
                :search="search"
                density="compact"
            >
                <template v-slot:item.actions="{ item }">
                    <v-btn size="x-small" variant="text" @click="$router.push(`/user/${item.id}`)">Editar</v-btn>
                    <!-- <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn icon="mdi-dots-vertical" v-bind="props" variant="plain"></v-btn>
                        </template>

                        <v-list density="compact" nav>
                            <v-list-item
                                value="editar"
                                prepend-icon="mdi-square-edit-outline"
                                @click="$router.push(`/user/${item.id}`)"
                            >
                                <v-list-item-title>Editar</v-list-item-title>
                            </v-list-item>
                            <v-list-item 
                                value="configurar"
                                prepend-icon="mdi-cog"
                                @click="$router.push(`/user-profile/${item.raw.id}`)"
                            >
                                <v-list-item-title>Configurar</v-list-item-title>
                            </v-list-item>
                            <v-list-item
                                value="eliminar"
                                prepend-icon="mdi-delete"
                                @click="deleteItem(item.raw)"
                            >
                                <v-list-item-title>Eliminar</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu> -->
                </template>
        
            </v-data-table>
        </template>

        <template v-slot:right_content>
        </template>

    </PageComponent>
    <v-row justify="center">
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
    </v-row>
    <Overlay v-if="loading" />
</template>
<script>

import store from '../../../store';
import { computed } from 'vue';
import axiosClient from '../../../axios';
import PageComponent from '../../PageComponent.vue'
import Overlay from '../../Overlay.vue';

export default {
    data() {
        return {
            loading: false,
            dialog: false,
            password_reset: false,
            user: computed(() => store.state.user.data),
            usuario: {},
            breadcrumbs: [
                { title: 'Dashboard', disabled: false, href: '/' },
                { title: 'Usuarios', disabled: true, href: '/users' },
                { title: 'Nuevo', disabled: false, href: '/user/new' },
            ],
            search: '',
            itemsPerPage: 20,
            headers: [
                { title: 'Nombre', align: 'start', sortable: true, key: 'name' },
                { title: 'Email', align: 'start', sortable: true, key: 'email' },
                { title: 'Rol', align: 'start', sortable: true, key: 'rol' },
                { title: '', align: 'end',key: 'actions', sortable: false },
            ],
            status: [
                { id: 1, nombre: 'Activo' },
                { id: 2, nombre: 'Inctivo' },
            ],
            usuarios: [],
            system_roles: [],
        }
    },
    created() {
        this.initReg();
        this.users();
        // this.getSystemRoles();
    },
    methods: {
        async users() {
            let _this = this;
            this.loading = true;

            axiosClient.get(`/user`, this.requestHeaders())
                .then(response => {
                    _this.usuarios = response.data;

                    _this.usuarios.sort((a, b) => {
                        if (a.nombre < b.nombre) return -1;
                    });

                    _this.loading = false;
                })
                .catch(function (error) {
                    // console.log(error.response.status);
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
                    // _this.$emit('system-usuarios');
                })
                .catch(function (error) {
                    console.log(error.response.status);
                    this.loading = false;
                });
        },
        nuevo() {
            this.initReg();
            this.dialog = true;
        },
        editItem (item) {
            console.log(item)
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