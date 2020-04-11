<template>
    <default-field :errors="errors" :field="field">
        <template slot="field">
            <div class="sb-field-images">
                <div :key="index" v-for="(img, index) in previewUrl">
                    <img
                        :class="{ 'rounded-full': field.rounded, rounded: !field.rounded }"
                        :src="img"
                        alt=""
                    />

                    <p class="flex pt-2 mb-4 items-center text-sm">
                        <button
                            :dusk="field.attribute + '-delete-link'"
                            @click.prevent="removeFile(index)"
                            @keydown.enter.prevent="removeFile(index)"
                            class="cursor-pointer dim btn btn-link text-primary inline-flex items-center"
                            tabindex="0"
                            type="button"
                        >
                            <icon height="16" type="delete" view-box="0 0 20 20" width="16"/>
                            <span class="class ml-2 mt-1"> {{ __('Delete') }} </span>
                        </button>
                    </p>
                </div>
            </div>

            <div class="form-file" style="color: #666666">
                <input
                    :accept="field.acceptedTypes"
                    :dusk="field.attribute"
                    :id="field.attribute"
                    :name="field.attribute"
                    @change="fileChange"
                    class="form-file-input select-none"
                    multiple
                    type="file"
                />

                <label :for="field.attribute" class="form-file-btn btn btn-default btn-primary select-none">
                    {{ __('Choose File') }}
                </label>

                <span class="mx-3"> {{ currentLabel }} </span>

                <span v-show="showOrderType">
                    {{ __('order type') }}：

                    <label>
                        <input type="radio" v-model="order" value="before"> {{ __('before') }}
                    </label>

                    <label>
                        <input type="radio" v-model="order" value="after"> {{ __('after') }}
                    </label>
                </span>
            </div>
        </template>
    </default-field>
</template>

<script>
    import { FormField, HandlesValidationErrors } from 'laravel-nova'

    export default {
        mixins: [FormField, HandlesValidationErrors],

        props: ['resourceName', 'resourceId', 'field'],

        data () {
            return {
                removeModalOpen: false,
                previewUrl: [],
                paths: [],
                deletes: [],
                order: null,
                value: [],
            }
        },

        computed: {
            currentLabel () {
                return this.showOrderType ? this.__('selected :count file', { count: this.value.length }) : this.__('no file selected')
            },
            showOrderType () {
                return this.value.length > 0
            }
        },

        methods: {
            setInitialValue () {
                this.value = []
                this.paths = this.field.value || []
                this.order = this.field.order || 'before'
                this.previewUrl = this.field.previewUrl || []
            },

            fill (formData) {
                formData.append('order', this.order)

                Array.from(this.value).forEach(file => {
                    formData.append(this.field.attribute + '[]', file)
                })

                this.deletes.forEach(file => {
                    formData.append('deletes[]', file)
                })
            },

            removeFile (index) {
                this.previewUrl.splice(index, 1)
                this.deletes.push(this.paths.splice(index, 1))

                this.$emit('file-deleted')
            },

            fileChange (event) {
                this.value = Array.from(event.target.files)

                this.$emit('file-change')
            }
        },
    }
</script>
