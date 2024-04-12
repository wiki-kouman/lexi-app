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
    const languageDropdown = $('#language')

    /**
     * Use previously defined selectors
     */
    const definitionRepeaterContainer = $(definitionContainerSelector)
    const addButton = $(addButtonSelector)
    const deleteButton = $(deleteButtonSelector)

    /**
     * Display and hide visibility buttons
     * under certain conditions.
     */
    const setDeleteButtonVisibility = () => {
        const childCount = $(definitionContainerSelector).children.length
        if( childCount > 1 ) {
            deleteButton.removeClass('hidden')
        } else {
            deleteButton.addClass('hidden')
        }
    }

    const init = () => {
        setDeleteButtonVisibility();
    }

    /**
     * Add a new node as a clone
     */
    addButton.click((e) => {
        e.preventDefault();
        const template = $(repeaterSelector).clone(true)
        definitionRepeaterContainer.append(template)
        setDeleteButtonVisibility()
    })

    /**
     * Handle deletion of latest node elemt
     */
    deleteButton.click((e) => {
        e.preventDefault();
        const parentNode = $(definitionContainerSelector)
        const lastNode = parentNode.lastChild
        if(parentNode.children.length > 1) {
            parentNode.remove(lastNode)
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
