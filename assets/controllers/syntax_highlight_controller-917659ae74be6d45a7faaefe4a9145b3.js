import {Controller} from '@hotwired/stimulus';
import 'highlight.js/styles/github-dark.min.css';
import php from 'highlight.js/lib/languages/php';
import shell from 'highlight.js/lib/languages/shell';
import json from 'highlight.js/lib/languages/json';
import twig from 'highlight.js/lib/languages/twig';
import sql from 'highlight.js/lib/languages/sql';
import hljs from 'highlight.js/lib/core';

/* stimulusFetch: 'lazy' */
export default class extends Controller
{
    initialize()
    {
        hljs.registerLanguage('php', php);
        hljs.registerLanguage('shell', shell);
        hljs.registerLanguage('json', json);
        hljs.registerLanguage('sql', sql);
        hljs.registerLanguage('twig', twig);
    }

    connect()
    {
        hljs.highlightElement(this.element);
    }
}