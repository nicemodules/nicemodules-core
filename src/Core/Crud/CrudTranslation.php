<?php

namespace NiceModules\Core\Crud;

use NiceModules\Core\Context;

class CrudTranslation
{
    public function get()
    {
        $l = Context::instance()->getLang();

        return [
            'badge' => $l->get('Badge'),
            'close' => $l->get('Close'),
            'dataIterator' => [
                'noResultsText' => $l->get('No matching records found'),
                'loadingText' => $l->get('Loading items...'),
            ],
            'dataTable' => [
                'itemsPerPageText' => $l->get('Rows per page:'),
                'ariaLabel' => [
                    'sortDescending' => $l->get('Sorted descending.'),
                    'sortAscending' => $l->get('Sorted ascending.'),
                    'sortNone' => $l->get('Not sorted.'),
                    'activateNone' => $l->get('Activate to remove sorting.'),
                    'activateDescending' => $l->get('Activate to sort descending.'),
                    'activateAscending' => $l->get('Activate to sort ascending.'),
                ],
                'sortBy' => $l->get('Sort by'),
            ],
            'dataFooter' => [
                'itemsPerPageText' => $l->get('Items per page:'),
                'itemsPerPageAll' => $l->get('All'),
                'nextPage' => $l->get('Next page'),
                'prevPage' => $l->get('Previous page'),
                'firstPage' => $l->get('First page'),
                'lastPage' => $l->get('Last page'),
                'pageText' => $l->get('{0}-{1} of {2}'),
            ],
            'datePicker' => [
                'itemsSelected' => $l->get('{0} selected'),
                'nextMonthAriaLabel' => $l->get('Next month'),
                'nextYearAriaLabel' => $l->get('Next year'),
                'prevMonthAriaLabel' => $l->get('Previous month'),
                'prevYearAriaLabel' => $l->get('Previous year'),
                'form' => $l->get('from'),
                'to' => $l->get('to'),
            ],
            'noDataText' => $l->get('No data available'),
            'carousel' => [
                'prev' => $l->get('Previous visual'),
                'next' => $l->get('Next visual'),
                'ariaLabel' => [
                    'delimiter' => $l->get('Carousel slide {0} of {1}'),
                ],
            ],
            'calendar' => [
                'moreEvents' => $l->get('{0} more'),
            ],
            'fileInput' => [
                'counter' => $l->get('{0} files'),
                'counterSize' => $l->get('{0} files ({1} in total)'),
            ],
            'timePicker' => [
                'am' => $l->get('AM'),
                'pm' => $l->get('PM'),
            ],
            'pagination' => [
                'ariaLabel' => [
                    'wrapper' => $l->get('Pagination Navigation'),
                    'next' => $l->get('Next page'),
                    'previous' => $l->get('Previous page'),
                    'page' => $l->get('Goto Page {0}'),
                    'currentPage' => $l->get('Current Page, Page {0}'),
                ],
            ],
            'rating' => [
                'ariaLabel' => [
                    'icon' => $l->get('Rating {0} of {1}'),
                ],
            ],
            'buttons' => [
                'add' => $l->get('Add'),
                'filter' => $l->get('Filter'),
                'cancel' => $l->get('Cancel'),
                'save' => $l->get('Save'),
                'delete' => $l->get('Delete'),
                'edit' => $l->get('Edit'),
                'ok' => $l->get('OK'),
                'clear' => $l->get('Clear'),
            ],
            'labels' => [
                'selected' => $l->get('Selected'),
            ], 
            'messages'=> [
                'confirmDelete' => $l->get('Are you sure you want to delete this?'),
                'unselected' => $l->get('You must tick at least one thing.')
            ]
        ];
    }
}