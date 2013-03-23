<?php

/**
 * Custom Exception handler. 
 */
class ExceptionClass extends Exception {
  /**
   * Magic __toString().
   * @return string 
   */
  public function __toString() {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}