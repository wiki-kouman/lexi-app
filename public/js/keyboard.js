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

    let closestInput = false
    const keyboardContainer = $('.diacritrics-keyboard')
    const keyboardToggleButtons = $('.keyboard-button')
    const keyboardInput = $('.keyboard-input')

    /**
     * Display and hide visibility buttons
     * under certain conditions.
     */
    const toggleKeyboardVisibility = () => {
        keyboardContainer.toggleClass('hidden')
    }

    keyboardToggleButtons.click(function() {
        toggleKeyboardVisibility();
        closestInput =  $(this).parent().find('input')
        closestInput.focus()
    })

    // Update closest input
    keyboardInput.focus(function () {
        closestInput = $(this)
    })

    /**
     * Credit goes to awesome work of @bonaventuredossou
     * which was releaed for free under the terms of the MIT License.
     * @link https://github.com/bonaventuredossou/clavierfongbe
     */
    let shift = false;
    let capslock = false;

    // Hide keyboard when "x" is clicked
    $(keyboardContainer).find('.close').click(function () {
        keyboardContainer.toggleClass('hidden')
    })

    $(keyboardContainer).find('li').click(function () {

        let $this = $(this), character = $this.html(); // If it's a lowercase letter, nothing happens to this variable

        // Shift keys
        if ($this.hasClass("left-shift")) {
            $(".diacritics").toggleClass("uppercase");

            shift = shift !== true;
            capslock = false;
            return false;
        }

        // Caps lock
        if ($this.hasClass("capslock")) {
            $(".diacritics").toggleClass("uppercase");
            capslock = true;
            return false;
        }

        // Bold
        if ($this.hasClass("bold") || $this.hasClass("italicize")) {

            // Only if a portion of the text is selected
            if(closestInput[0].selectionEnd > 0){
                const selectionStartIndex = closestInput[0].selectionStart;
                const selectionEndIndex = closestInput[0].selectionEnd;
                const currentText = closestInput.val()
                // Replace text
                let selectedText = closestInput.val().substring(selectionStartIndex, selectionEndIndex)
                let newText = currentText.substring(0, selectionStartIndex)

                // Use 2 apostrophes for Bold and 3 for italic
                const tag = ($this.hasClass("bold")) ? "''" : "'''"
                newText += tag + selectedText + tag
                newText += currentText.substring(selectionEndIndex, currentText.length);

                // Replace nad set cursor back in place
                closestInput.val(newText)
                closestInput.focus()
            }

        }

        // Italicize
        if ($this.hasClass("italicize")) {
            $(".diacritics").toggleClass("uppercase");
            capslock = true;
            return false;
        }

        // Uppercase letter
        if ($this.hasClass("uppercase")) character = character.toUpperCase();

        // Remove shift once a key is clicked.
        if (shift === true) {
            if (capslock === false) {
                $(".diacritics").toggleClass("uppercase");
            }
            shift = false;
        }

        // Add the character if there was a change
        let prevInputValue = closestInput.val()
        if(character !== prevInputValue){
            closestInput.val(prevInputValue + character)
            // Set cursor back in place
            closestInput.focus()
        }
    });
})
