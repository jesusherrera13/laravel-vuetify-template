<template>
    <PageComponent title="Settings">
        <template v-slot:content>
            <v-row>
                <v-col cols="3">
                    <v-list
                        :lines="false"
                        density="compact"
                        nav
                    >
                        <v-list-item
                            v-for="(item, i) in items"
                            :key="i"
                            :value="item"
                            color="primary"
                            :to="item.route"
                        >
                            <template v-slot:prepend>
                                <v-icon :icon="item.icon"></v-icon>
                            </template>
                            
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col>
                    <router-view></router-view>
                </v-col>
            </v-row>
        </template>

        <template v-slot:right_content>
        </template>

    </PageComponent>
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
                { title: 'Usuarios', disabled: true, href: '/userx' },
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
            items: [
                { text: 'Users', icon: 'mdi-account-multiple', route:'/userx'},
                { text: 'Starred', icon: 'mdi-star' },
                { text: 'Recent', icon: 'mdi-history' },
                { text: 'Offline', icon: 'mdi-check-circle' },
                { text: 'Uploads', icon: 'mdi-upload' },
                { text: 'Backups', icon: 'mdi-cloud-upload' },
            ]
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