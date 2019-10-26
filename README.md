struggle-for-php/sfp-coding-standard-sniffs-di
----------------------------------------------

## ForbiddenInstantiationSniff 
 
 
### setup in your phpcs.xml

eg.
```
<property name="forbiddenInstantiations" type="array">
    <element key="factoryClass" value="class" / >
    <element key="Vendor\\PdoFactory" value="PDO" / >
    <element key="Vendor\\FooServiceFactory" value="FooServiceInterface" / >
```

### Todos