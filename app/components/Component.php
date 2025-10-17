<?php

abstract class Component {
    protected $data;
    protected $options;
    
    public function __construct($data = [], $options = []) {
        $this->data = $data;
        $this->options = $options;
    }
    
    abstract public function render();
    
    protected function getOption($key, $default = null) {
        return $this->options[$key] ?? $default;
    }
    
    protected function getData($key, $default = null) {
        return $this->data[$key] ?? $default;
    }
    
    protected function renderCSS() {
        // Override in child classes to add component-specific CSS
        return '';
    }
    
    protected function renderJS() {
        // Override in child classes to add component-specific JavaScript
        return '';
    }
    
    public function renderWithAssets() {
        $css = $this->renderCSS();
        $js = $this->renderJS();
        $html = $this->render();
        
        return [
            'html' => $html,
            'css' => $css,
            'js' => $js
        ];
    }
}
