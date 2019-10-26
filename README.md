struggle-for-php/sfp-coding-standard-sniffs-di
----------------------------------------------

## ForbiddenInstantiationSniff 
 
 
### setup in your phpcs.xml
```
<property name="forbiddenInstantiations" type="array">
    <element key="factoryClass" value="class" / >
    <element key="Vendor\\PdoFactory" value="PDO" / >
```