struggle-for-php/sfp-coding-standard
----------------------------------------------

## ForbiddenInstantiationSniff 

### setup in your phpcs.xml

eg.
```
    <config name="installed_paths" value="../../slevomat/coding-standard,../../struggle-for-php/sfp-coding-standard"/>
    <rule ref="SfpCodingStandard.Di.ForbiddenInstantiation">
        <properties>
            <property name="forbiddenInstantiations" type="array">
                <element key="App\\PdoFactory" value="PDO"/>
            </property>
        </properties>
    </rule>
```

### Todos