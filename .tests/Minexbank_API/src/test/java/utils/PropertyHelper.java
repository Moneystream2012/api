package utils;

import java.io.IOException;
import java.io.InputStream;
import java.util.Properties;

public class PropertyHelper {

    public static String getProperty(String propertyName) {
        Properties properties = new Properties();
        String propertiesFileName = System.getProperty("env") + ".properties";
        try {
            InputStream stream =
                    Thread.currentThread()
                            .getContextClassLoader()
                            .getResourceAsStream(propertiesFileName);
            properties.load(stream);
        } catch (IOException e) {
            e.printStackTrace();
        }

        return properties.getProperty(propertyName);
    }
}
