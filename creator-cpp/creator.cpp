#include <iostream>
#include <fstream>
#include <string>
#include "manager.h"

using namespace std;

int maina()
{

    Column column[20];
    Element element;

    cout << "\nModel =";
    cin >> element.model;

    cout << "\nModel with S =";
    cin >> element.models;

    cout << "\nTable =";
    cin >> element.table;

    cout << "\nSingle =";
    cin >> element.single;

    cout << "\nArabic Single =";
    cin >> element.arabicSingle;
    cout << "\nArabic Name =";
    cin >> element.arabic;
    cout << "\nColumn Counts =";
    cin >> element.columnCount;

    cout << "\nPage Id =";
    cin >> element.pageId;

    for (int i = 0; i < element.columnCount; i++)
    {
        cout << "Enter Column " << i + 1 << " Name = ";
        cin >> column[i].name;

        cout << "Arabic Column = ";
        cin >> column[i].arabic;

        cout << "Enter Column " << i + 1 << " Type Number ";
        cout << "String 1 - Integer 2 - Text 3 - Boolean 4 - Double 5 - Json 6 =";
        cin >> column[i].type;
        if (column[i].type == "1")
            column[i].type = "string";
        else if (column[i].type == "2")
            column[i].type = "integer";
        else if (column[i].type == "3")
            column[i].type = "text";
        else if (column[i].type == "4")
            column[i].type = "boolean";
        else if (column[i].type == "5")
            column[i].type = "double";
        else if (column[i].type == "6")
            column[i].type = "json";

        cout << "Enter IF Search Y/N = ";
        cin >> column[i].search;

        cout << "Enter IF Show In List Y/N = ";
        cin >> column[i].showInList;
    }

    create_controller(element, column);
    create_model(element, column);
    create_table(element, column);
    create_permissions(element, column);
    create_route_api(element, column);
    create_js_lists(element, column);
    create_js_item(element, column);
    create_js_edit_item(element, column);
    create_js_new_item(element, column);
    create_js_route_dataservices(element, column);

    return 0;
}

int main()
{
    Column column[20];
    Element element;

    string filename;
    cout << "Enter the name of the text file: ";
    cin >> filename;

    ifstream inputFile(filename);
    if (!inputFile.is_open())
    {
        cout << "Failed to open the file." << endl;
        return 1;
    }

    // Read element properties from the file
    inputFile >> element.model;
    inputFile >> element.models;
    inputFile >> element.table;
    inputFile >> element.single;
    inputFile >> element.arabicSingle;
    inputFile >> element.arabic;
    inputFile >> element.columnCount;
    inputFile >> element.pageId;

    // Read column properties from the file
    for (int i = 0; i < element.columnCount; i++)
    {
        inputFile >> column[i].name;
        inputFile >> column[i].arabic;
        inputFile >> column[i].type;

        inputFile >> column[i].search;
        inputFile >> column[i].showInList;


    }

    inputFile.close();

    // Rest of the code...
    create_controller(element, column);
    create_model(element, column);
    create_table(element, column);
    create_permissions(element, column);
    create_route_api(element, column);
    create_js_lists(element, column);
    create_js_item(element, column);
    create_js_edit_item(element, column);
    create_js_new_item(element, column);
    create_js_route_dataservices(element, column);

    return 0;
}