<template>
    <PageComponent title="Módule">
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
                    
                        <h6>{{ modulo_.name }}</h6>
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
            <v-row>
                <v-col cols="3">
                    <!-- <v-row>
                        <v-col align="center">
                            <v-avatar color="surface-variant" size="200"></v-avatar>
                        </v-col>
                    </v-row> -->
                    <v-row v-if="edit">
                        <v-col
                            cols="12"
                        >
                            <v-text-field v-show="false"
                                v-model="modulo.id"
                                type="hidden"
                            ></v-text-field>
                            <v-text-field
                                v-model="modulo.name"
                                label="Nombre"
                                required
                                density="compact"
                                variant="outlined"
                            ></v-text-field>
                            <v-text-field
                                v-model="modulo.key"
                                label="key"
                                hint="Escriba una key"
                                required
                                density="compact"
                                variant="outlined"
                            ></v-text-field>
                            <v-text-field
                                v-model="modulo.route"
                                label="Route"
                                hint="Escriba una ruta"
                                required
                                density="compact"
                                variant="outlined"
                            ></v-text-field>
                            <v-text-field
                                v-model="modulo.mdi_icon"
                                label="Icon"
                                hint="Icon"
                                required
                                :readonly="modulo.id ? true : false"
                                density="compact"
                                variant="outlined"
                            ></v-text-field>
                            <v-select
                                v-model="modulo.rol_id"
                                label="Rol"
                                item-value="id"
                                item-title="nombre"
                                :items="system_roles"
                                density="compact"
                                variant="outlined"
                            ></v-select>
                            <v-btn
                                size="small"
                                color="primary"
                                class="me-2"
                                @click="save"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-if="modulo.id"
                                size="small"
                                color="secondary"
                                class="me-2"
                                @click="toggleEdit"
                            >
                                Cancelar
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-row v-else cols="3">
                        <v-col
                            cols="12"
                        >
                            <div class="text-h6">{{ modulo.name }}</div>
                            <div>{{ modulo.email }}</div>
                            <div>{{ modulo.key }}</div>
                            <div>{{ modulo.route }}</div>
                            <v-btn
                                size="small"
                                @click="edit =!edit"
                                class="mr-1"
                                density="default"
                            >
                                Editar
                            </v-btn>
                        </v-col>
                    </v-row>
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
            edit: false,
            loading: false,
            dialog: false,
            password_reset: false,
            user: computed(() => store.state.user.data),
            modulo: {},
            modulo_: {},
            breadcrumbs: [
                { title: 'Dashboard', disabled: false, href: '/' },
                { title: 'Módulos', disabled: false, href: '/modules' },
                { title: 'Nuevo', disabled: false, href: '/module/new' },
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
            modulos: [],
            system_roles: [],
        }
    },
    created() {
        
        if(parseInt(this.$route.params.id)) {
            this.initReg();
            this.getData();
        }
        else {
            this.edit = 1;
        }
    },
    methods: {
        async getData() {
            let _this = this;
            this.loading = true;

            axiosClient.get(`/module/${this.$route.params.id}`)
                .then(response => {
                    _this.modulo = response.data;
                    _this.modulo_ = {..._this.modulo};
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
        async save() {
            let _this = this;
            this.loading = true;

            let url = '';
            let payload = {
                ...this.modulo,
                cuenta_id: this.user.cuenta_id
            };

            if(this.modulo.id) {

                url += `/user/${this.modulo.id}`;
                payload._method = 'PUT';
            }
            else url += `/register`;

            axiosClient.post(`${url}`, payload, this.requestHeaders())
                .then(response => {
                    _this.initReg();
                    _this.getData();
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
            this.modulo = {...item};
            this.dialog = true;
        },
        deleteItem (item) {
            this.editedIndex = this.desserts.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },
        setResetPassword () {
            this.modulo.password = null;
            this.modulo.password_confirmation = null;
            this.password_reset = !this.password_reset;
        },
        initReg() {
            this.modulo = { id: null, name: null, email: null, password: null, rol_id: 1 };
        },
        requestHeaders() {
            return {headers: { Authorization: `Bearer ${this.token}` }};
        },
        toggleEdit() {
            this.edit = !this.edit;
            this.modulo = {...this.modulo_};
        }
    },
    components: {
        PageComponent,
        Overlay,
    },
    watch: {
        modulo(val, oldval) {
        }
    }
}

</script>