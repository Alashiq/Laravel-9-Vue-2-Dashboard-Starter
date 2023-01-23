#include <iostream>
#include <fstream>
#include <string>
#include <locale>

using namespace std;

struct Column
{
    std::string name;
    std::string type;
    std::string search;
    std::string showInList;
    std::string arabic;
};

struct Element
{
    std::string table;
    std::string model;
    std::string models;
    std::string single;

    std::string arabicSingle;
    std::string arabic;
    int columnCount;
};

string to_lower(string s)
{
    for (char &c : s)
        c = tolower(c);
    return s;
}

void create_controller(Element element, Column column[20])
{
    std::string sourcePath = "Files/Controller.php";
    std::string destinationPath = "../app/Features/Admin/Controllers/" + element.model + "Controller.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        // Change Class Name
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, element.model);

        // Add Search Filter
        if (data.find("//xSearchColumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                {
                    fill = fill + "->where('" + column[i].name + "', 'like', '%' . $request->" + column[i].name + " . '%') \n";
                }
            }
            data.replace(data.find("//xSearchColumn"), 15, fill);
        }

        // Add Colum to Edit Item
        if (data.find("//xEditColumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                fill = fill + "if ($request['" + column[i].name + "'] != null) \n";
                fill = fill + "$item->" + column[i].name + " = $request['" + column[i].name + "']; \n\n";
            }
            data.replace(data.find("//xEditColumn"), 13, fill);
        }

        // Add Colum to Insert Item
        if (data.find("//xInserColumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                fill = fill + "'" + column[i].name + "' => $request['" + column[i].name + "'], \n";
            }
            data.replace(data.find("//xInserColumn"), 14, fill);
        }

        // Change Arabic Name
        if (data.find("xarabic") != std::string::npos)
            data.replace(data.find("xarabic"), 7, element.arabic);
        if (data.find("xsinglearabic") != std::string::npos)
            data.replace(data.find("xsinglearabic"), 13, element.arabicSingle);

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}

void create_model(Element element, Column column[20])
{
    std::string sourcePath = "Files/Model.php";
    std::string destinationPath = "../app/Models/" + element.model + ".php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, element.model);

        if (data.find("xcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                fill = fill + "'" + column[i].name + "',\n";
            }
            data.replace(data.find("xcolumn"), 7, fill);
        }

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}

void create_table(Element element, Column column[20])
{
    // Copy Table File
    std::string sourcePath = "Files/Table.php";
    std::string destinationPath = "../database/migrations/create_" + element.table + "_table.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xtable") != std::string::npos)
            data.replace(data.find("xtable"), 6, element.table);

        if (data.find("xcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {

                fill = fill + "$table->" + column[i].type + "('" + column[i].name + "');\n";
            }
            data.replace(data.find("xcolumn"), 7, fill);
        }

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}

void create_permissions(Element element, Column column[20])
{
    std::string sourcePath = "../config/permissions.php";
    std::string destinationPath = "../config/permissions_swap.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("//xpermissions") != std::string::npos)
        {
            string fill = "";
            fill = fill + "// Role " + element.model + "\n";
            fill = fill + "'Read" + element.model + "'=>'Read " + element.table + "', \n";
            fill = fill + "'Create" + element.model + "'=>'Create " + element.table + "', \n";
            fill = fill + "'Edit" + element.model + "'=>'Edit " + element.table + "', \n";
            fill = fill + "'Delete" + element.model + "'=>'Delete " + element.table + "', \n\n\n\n";
            fill = fill + "//xpermissions \n";
            data.replace(data.find("//xpermissions"), 14, fill);
        }
        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
    // Swap
    std::string sourcePath2 = "../config/permissions_swap.php";
    std::string destinationPath2 = "../config/permissions.php";
    std::ifstream sourceFile2(sourcePath2, std::ios::binary);
    std::ofstream destinationFile2(destinationPath2, std::ios::binary);
    std::string data2;
    destinationFile2 << sourceFile2.rdbuf();
    sourceFile2.close();
    destinationFile2.close();
}

void create_route_api(Element element, Column column[20])
{
    std::string sourcePath = "../app/Features/Admin/Routes/api.php";
    std::string destinationPath = "../app/Features/Admin/Routes/api_swap.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {

        if (data.find("//ximport") != std::string::npos)
            data.replace(data.find("//ximport"), 9, "use App\\Features\\Admin\\Controllers\\" + element.model + "Controller; \n\n\n //ximport");

        if (data.find("#xRoute") != std::string::npos)
        {
            string fill = "# # # # # # # # # # # # # # # # #  " + element.table + "  # # # # # # # # # # # # # # # # #\n";
            fill = fill + "Route::controller(" + element.model + "Controller::class)->prefix('" + to_lower(element.model) + "')->group( \n";
            fill = fill + "function () { \n";
            fill = fill + "Route::get('/', [" + element.model + "Controller::class, 'index'])->middleware('check.role:Read" + element.model + "'); \n";
            fill = fill + "Route::delete('/{id}', [" + element.model + "Controller::class, 'delete'])->middleware('check.role:Delete" + element.model + "'); \n";
            fill = fill + "Route::get('/{id}', [" + element.model + "Controller::class, 'show'])->middleware('check.role:Read" + element.model + "'); \n";
            fill = fill + "Route::put('/{id}', [" + element.model + "Controller::class, 'edit'])->middleware('check.role:Edit" + element.model + "'); \n";
            fill = fill + "Route::post('/', [" + element.model + "Controller::class, 'create'])->middleware('check.role:Create" + element.model + "'); \n";
            fill = fill + "} \n";
            fill = fill + "); \n";
            fill = fill + "# # # # # # # # # # # # # # # # # End " + element.table + "  # # # # # # # # # # # # # # #  \n";
            fill = fill + " \n";
            fill = fill + "#xRoute \n";
            data.replace(data.find("#xRoute"), 7, fill);
        }
        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
    // Swap
    std::string sourcePath2 = "../app/Features/Admin/Routes/api_swap.php";
    std::string destinationPath2 = "../app/Features/Admin/Routes/api.php";
    std::ifstream sourceFile2(sourcePath2, std::ios::binary);
    std::ofstream destinationFile2(destinationPath2, std::ios::binary);
    std::string data2;
    destinationFile2 << sourceFile2.rdbuf();
    sourceFile2.close();
    destinationFile2.close();
}

void create_js_lists(Element element, Column column[20])
{

    // Copy Vue File
    std::string sourcePath = "Files/List/List.vue";
    std::string destinationPath = "../resources/js/admin/pages/" + element.model + "s/" + element.models + ".vue";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;
    while (std::getline(sourceFile, data))
    {
        if (data.find("xfile") != std::string::npos)
            data.replace(data.find("xfile"), 5, element.models);
        destinationFile << data << "\n";
    }
    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();

    // Copy Js File
    std::string sourcePath2 = "Files/List/List.js";
    std::string destinationPath2 = "../resources/js/admin/pages/" + element.models + "/" + element.models + ".js";
    std::ifstream sourceFile2(sourcePath2, std::ios::binary);
    std::ofstream destinationFile2(destinationPath2, std::ios::binary);
    std::string data2;
    while (std::getline(sourceFile2, data2))
    {
        if (data2.find("xmodel") != std::string::npos)
            data2.replace(data2.find("xmodel"), 6, element.model);
        if (data2.find("xsingleArabic") != std::string::npos)
            data2.replace(data2.find("xsingleArabic"), 13, element.arabicSingle);

        if (data2.find("//xcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                    fill = fill + column[i].name + "Srh:'',\n";
            }
            data2.replace(data2.find("//xcolumn"), 9, fill);
        }

        if (data2.find("//xclearcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                    fill = fill + "this."+column[i].name + "Srh='',\n";
            }
            data2.replace(data2.find("//xclearcolumn"), 14, fill);
        }

        if (data2.find("//Parxcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                    fill = fill + ",this." + column[i].name + "Srh";
            }
            data2.replace(data2.find("//Parxcolumn"), 12, fill);
        }

        destinationFile2 << data2 << "\n";
    }
    destinationFile2 << sourceFile2.rdbuf();
    sourceFile2.close();
    destinationFile2.close();

    // Copy HTML File
    std::string sourcePath3 = "Files/List/List.html";
    std::string destinationPath3 = "../resources/js/admin/pages/" + element.models + "/" + element.models + ".html";
    std::ifstream sourceFile3(sourcePath3, std::ios::binary);
    std::ofstream destinationFile3(destinationPath3, std::ios::binary);
    std::string data3;
    while (std::getline(sourceFile3, data3))
    {
        if (data3.find("xmodel") != std::string::npos)
            data3.replace(data3.find("xmodel"), 6, element.model);
        if (data3.find("xsingle") != std::string::npos)
            data3.replace(data3.find("xsingle"), 7, element.single);
        if (data3.find("xarabic") != std::string::npos)
            data3.replace(data3.find("xarabic"), 7, element.arabic);
        if (data3.find("xsinglearabic") != std::string::npos)
            data3.replace(data3.find("xsinglearabic"), 13, element.arabicSingle);

        if (data3.find("//xsearchcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                {
                    fill = fill + " <!-- Item -->\n";
                    fill = fill + "<div class='xl:w-1/4 lg:w-1/3 md:w-1/2 w-full px-2 mt-4'>\n";
                    fill = fill + "<div class='text-gray-400 text-sm cairo h-8 flex items-center mr-2'>" + column[i].arabic + "</div>\n";
                    fill = fill + "<input type='text' v-model='" + column[i].name + "Srh' placeholder='" + column[i].arabic + "' \n";
                    fill = fill + "class='w-full h-12 border border-gray-300 rounded outline-green-600 cairo placeholder:text-sm px-4'>\n";
                    fill = fill + "</div>\n";
                    fill = fill + " <!-- End Item -->\n\n";
                }
            }
            data3.replace(data3.find("//xsearchcolumn"), 15, fill);
        }

        if (data3.find("//xheadercolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].showInList == "y" || column[i].showInList == "Y")
                    fill = fill + "<td class='table-cell'>" + column[i].arabic + "</td>";
            }
            data3.replace(data3.find("//xheadercolumn"), 15, fill);
        }

        if (data3.find("//xcontentcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].showInList == "y" || column[i].showInList == "Y")
                    fill = fill + "<td class='table-cell'> {{item." + column[i].name + "}}</td>";
            }
            data3.replace(data3.find("//xcontentcolumn"), 16, fill);
        }

        destinationFile3 << data3 << "\n";
    }
    destinationFile3 << sourceFile3.rdbuf();
    sourceFile3.close();
    destinationFile3.close();

    // Add APIs to DataServices
    std::string sourcePath4 = "../resources/js/admin/shared/DataServices.js";
    std::string destinationPath4 = "../resources/js/admin/shared/DataServices_swap.js";
    std::ifstream sourceFile4(sourcePath4, std::ios::binary);
    std::ofstream destinationFile4(destinationPath4, std::ios::binary);
    std::string data4;

    while (std::getline(sourceFile4, data4))
    {
        if (data4.find("//xapi") != std::string::npos)
        {
            string fill = "";
            fill = fill + "// ============== " + element.model + " Part =======================\n";
            fill = fill + "GetAll" + element.models + "(page,countPerPage";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                {
                    fill = fill + "," + column[i].name;
                }
            }
            fill = fill + ") { \n";
            fill = fill + "return axios.get('/admin/api/" + element.single + "?page=' + page + '&count=' + countPerPage";

            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                {
                    fill = fill + "+ '&" + column[i].name + "=' + " + column[i].name;
                }
            }
            fill = fill + ");";
            fill = fill + "\n}, \n\n";
            // Delete
            fill = fill + "Delete" + element.model + "(id){\n";
            fill = fill + "return axios.delete('/admin/api/" + element.single + "/' + id);\n";
            fill = fill + "}, \n";
            // Get By Id
            fill = fill + "Get" + element.model + "ById(id){\n";
            fill = fill + "return axios.get('/admin/api/" + element.single + "/' + id);\n";
            fill = fill + "}, \n";

            //  Post New
            fill = fill + "PostNew" + element.model + "(formData){\n";
            fill = fill + "return axios.post('/admin/api/" + element.single + "' + formData);\n";
            fill = fill + "}, \n";
            //  Edit
            fill = fill + "Edit" + element.model + "(id,formData){\n";
            fill = fill + "return axios.put('/admin/api/" + element.single + "/' + id , formData);\n";
            fill = fill + "}, \n";

            fill = fill + "\n\n\n //xapi";

            data4.replace(data4.find("//xapi"), 6, fill);
        }
        destinationFile4 << data4 << "\n";
    }

    destinationFile4 << sourceFile4.rdbuf();
    sourceFile4.close();
    destinationFile4.close();

    // Swap
    std::string sourcePath5 = "../resources/js/admin/shared/DataServices_swap.js";
    std::string destinationPath5 = "../resources/js/admin/shared/DataServices.js";
    std::ifstream sourceFile5(sourcePath5, std::ios::binary);
    std::ofstream destinationFile5(destinationPath5, std::ios::binary);
    std::string data5;
    destinationFile5 << sourceFile5.rdbuf();
    sourceFile5.close();
    destinationFile5.close();


    // Add To RouteJs File
    std::string sourcePath6 = "../resources/js/admin/routes/routes.js";
    std::string destinationPath6 = "../resources/js/admin/routes/routes_swap.js";
    std::ifstream sourceFile6(sourcePath6, std::ios::binary);
    std::ofstream destinationFile6(destinationPath6, std::ios::binary);
    std::string data6;

    while (std::getline(sourceFile6, data6))
    {
        if (data6.find("//ximport") != std::string::npos)
        {
            string fill = "";
            fill = fill + "import "+element.models+" from '../pages/"+element.models+"/"+element.models+".vue';\n";
            fill = fill + "import "+element.model+" from '../pages/"+element.models+"/"+element.model+"/"+element.model+".vue';\n";
            fill = fill + "\n\n\n //ximport";

            data6.replace(data6.find("//ximport"), 9, fill);
        }


                if (data6.find("//xroute") != std::string::npos)
        {
            string fill = "";
            fill = fill + "{ \n";
            fill = fill + "path: 'admin/"+element.single+"', \n";
            fill = fill + "component: "+element.models+" \n";
            fill = fill + "}, \n";
            fill = fill + "\n\n\n //xroute";

            data6.replace(data6.find("//xroute"), 8, fill);
        }
        destinationFile6 << data6 << "\n";
    }

    destinationFile6 << sourceFile6.rdbuf();
    sourceFile6.close();
    destinationFile6.close();

    // Swap
    std::string sourcePath7 = "../resources/js/admin/routes/routes_swap.js";
    std::string destinationPath7 = "../resources/js/admin/routes/routes.js";
    std::ifstream sourceFile7(sourcePath7, std::ios::binary);
    std::ofstream destinationFile7(destinationPath7, std::ios::binary);
    std::string data7;
    destinationFile7 << sourceFile7.rdbuf();
    sourceFile7.close();
    destinationFile7.close();


}