"use strict";

/**
 * MIT License
 * Copyright (c) 2024 Samuel Guebo <https://github.com/samuelguebo>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

$(function () {
    /**
     * Define Node selectors that will be used
     * with document.querySelector operations.
     */
    const definitionContainerSelector = '.example'
    const addButtonSelector = '.actions .btn-add'
    const deleteButtonSelector = '.actions .btn-delete'
    const repeaterSelector = '.repeater-container'
    const repeaterCountSelector = 'span.repeater-count'
    const errorModalSelector = '#errorModal'
    const errorModalTextSelector = '#errorModal .modal-body'
    const submitFormButtonSelector = '.actions button[type="submit"]'
    const languageDropdown = $('#language')

    /**
     * Use previously defined selectors
     */
    const addButton = $(addButtonSelector)
    const deleteButton = $(deleteButtonSelector)
    const submitFormButton = $(submitFormButtonSelector)

    /**
     * Display and hide visibility buttons
     * under certain conditions.
     */
    const setDeleteButtonVisibility = () => {
        updateRepeaterCount()
        const childrenCount = $(definitionContainerSelector).find(repeaterSelector).length

        deleteButton.addClass('hidden')
        $(repeaterSelector).addClass('hidden')

        if( childrenCount > 1 ) {
            deleteButton.removeClass('hidden')
            $(repeaterCountSelector).removeClass('hidden')
        }
    }

    /**
     * Validate form fields
     */
    submitFormButton.click((e) => {
        e.preventDefault();
        let form = $('form')[0];
        if (form.checkValidity() === false) {
            $(errorModalTextSelector).text()
            $(errorModalSelector).modal('show')
            form.classList.add('was-validated');
        } else{
            form.submit()
        }
    })

    const updateRepeaterCount = () => {
        let i = 0
        $(repeaterCountSelector).each(function () {
            $(this).text(i+1)
            i += 1
        })
    }
    const init = () => {
        setDeleteButtonVisibility();
    }

    /**
     * Add a new node as a clone
     */
    addButton.click((e) => {
        const template = $(repeaterSelector).last().clone(true)
        $(definitionContainerSelector).append(template)
        setDeleteButtonVisibility()
    })

    /**
     * Handle deletion of latest node elemt
     */
    deleteButton.click((e) => {
        const parentNode = $(definitionContainerSelector)
        const lastNode = $(repeaterSelector).last()
        if(parentNode.find(repeaterSelector).length > 1) {
            lastNode.remove()
            setDeleteButtonVisibility()
        }
    })

    /**
     * Update source language labels
     * upon language selector change
     */
    languageDropdown.change((e) => {
        const value = e.target.options[e.target.selectedIndex].text;
        $('.source-label').html(value)
    })

    init();

})
