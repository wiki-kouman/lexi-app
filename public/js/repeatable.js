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



window.addEventListener('load', () => {
    const definitionRepeaterContainer = document.querySelector('.example')
    const addButton = document.querySelector('.actions .btn-add')
    const deleteButton = document.querySelector('.actions .btn-delete')

    /**
     * Add a new element as a clone
     */
    addButton.addEventListener('click', (e) => {
        e.preventDefault();
        const template = document.querySelector('.repeater-container').cloneNode(true)
        definitionRepeaterContainer.append(template)
    })

    /**
     * Handle deletion of latest node elemt
     */
    deleteButton.addEventListener('click', (e) => {
        e.preventDefault();
        const lastNode = document.querySelector('.example').lastChild
        if(document.querySelector('.example').children.length > 1){
            definitionRepeaterContainer.removeChild(lastNode)
        }
    })


})
